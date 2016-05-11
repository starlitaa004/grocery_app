<?php require_once('header.php'); ?> 
<?php require_once('javascripts.php'); ?>  

<?php 
    $_SESSION["vatabletax"]="";
    $_SESSION["grandtotal"]="";
?>
<?php
    function getstorename() {
        $query = mysql_query("SELECT * FROM storeinfo WHERE storeid = ". $_SESSION['storeid']);
        $numrows = mysql_num_rows($query);

        if ( $numrows != 0 ) {
            $row = mysql_fetch_assoc($query);
            echo $row['storename'];
        }
    }
?>
<div class="container">
    <div class="block-header">
        <h2>
            <b id="storename">
                <?php getstorename(); ?>
            </b> 
            Products
            <small>Click Add to Cart for your order</small>
        </h2>
    </div>
    <div class="card">
        <div class="listview lv-bordered lv-lg">                
            <div class="lv-body">
                <?php viewcart(); ?>  
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<?php 
    function viewcart() {
        $getitem = mysql_query("SELECT i.item_num, i.item_desc, i.item_itemonhand, i.item_price, c.item_qty, 
                              (i.item_price * c.item_qty) AS subtotal
                              FROM item i, cart c 
                              WHERE i.item_num = c.item_num
                              AND c.customer_num = ". $_SESSION['user_id']);
        $num_rows = mysql_num_rows($getitem);

        $gtotal  = 0;
        $vatTax  = 0;
        $vaTable = 0;
        $num = 1;      
        $update = "btnUpdate"; 
        $remove = "btnDelete";
        $oqty = "txtoqty"; 
        $originalqty = "txtoriginal";
        $newtotal = "total";
        $subhidden = "subtot";
            while($res = mysql_fetch_assoc($getitem)) {
                $holdersaupdate = $num . $update;
                $holdersadelete = $num . $remove;
                $holdersatxtbox = $num . $oqty;
                $holderoriginalqty = $num . $originalqty;
                $holdersanewtotal = $num . $newtotal;
                $holdersasubtotalhidden = $num . $subhidden;
                echo '<div class="lv-item media">
                            <div class="media-body">
                                <div class="lv-title"><h5><b>'. $res['item_desc'] .'</b></h5></div>
                                <div style="padding-top: 10px;">
                                    <form method="post" action="viewcart.php?item_num='. $res['item_num'] .'">
                                        <small>Price: '. $res['item_price'] .' 
                                            <input type="text" name="item_num" value="'. $res['item_num'] .'" hidden> 
                                            <span style="padding-left: 5px; padding-right: 5px;color:red"> x </span>
                                            <input type="number" style="width:50px" min="1" max="'. $res['item_itemonhand'] .'" name="'.$holdersatxtbox.'" id="'.$holdersatxtbox.'" value="'. $res['item_qty'] .'"><span style="padding-left: 5px; padding-right: 5px;color:red"> = </span>
                                            <span style="padding-right: 10px; font-weight: bold"><label id= "'.$holdersanewtotal.'">'. number_format($res['subtotal'], 2) .'</label><input type="text" id= "'.$holdersasubtotalhidden.'" value="'. number_format($res['subtotal'], 2) .'" hidden></span>
                                        </small><br>
                                        <input type="text" name="'.$holderoriginalqty.'" value="'.$res['item_qty'].'" style="display:none;">
                                        <span style="padding-top: 10px">
                                        <button type="submit" name="' .$holdersaupdate.'" class="btn bgm-amber waves-effect"><i class="zmdi zmdi-edit zmdi-hc-fw"></i></button>
                                        <button type="submit" name="' .$holdersadelete.'" class="btn bgm-amber waves-effect"><i class="zmdi zmdi-delete zmdi-hc-fw"></i></button>
                                        </span>
                                </div>
                            </div>
                        </div>';
               $num++;

                if(isset($_POST["$holdersaupdate"]) && isset($_POST["$holdersatxtbox"]))
                {
                    $newqty = $_POST["$holdersatxtbox"];
                    $rqty = $_POST["$holdersatxtbox"];
                    $originalquantity = $_POST["$holderoriginalqty"];
                    $desc = $res['item_desc'];
                    $itemnumber = $res['item_num'];

                    if($rqty < $originalquantity)
                    {
                            $result = $originalquantity - $rqty;
                            
                            $rqty = mysql_query("UPDATE cart SET item_qty = '$rqty' 
                                            WHERE item_num = '$itemnumber' and customer_num ='".$_SESSION['user_id']."'")
                                            or die (mysql_error());
                            $update_stocks = mysql_query("UPDATE item 
                                            SET item_itemonhand = (item_itemonhand + $result) WHERE item_num = '$itemnumber'")
                                            or die (mysql_error());
?>
                        <script type="text/javascript">  
                                 var itemprice = "<?php echo $res['item_price'];?>";
                                 var newqty = "<?php echo $newqty;?>";
                                 var qty_textbox = "<?php echo $holdersatxtbox;?>";
                                 var newtotal_txtbox = "<?php echo $holdersanewtotal;?>";
                                 var subtotal_txtbox = "<?php echo $holdersasubtotalhidden?>";
                                 var newtotal = itemprice * newqty;
                                 var oldsub = document.getElementById(subtotal_txtbox).value;

                              $(window).load(function(){
                                 swal("Done", "A quantity on your cart has been deducted"+oldsub, "success");

                                 var gtotal = document.getElementById('gtotal').value;
                                 var comptotal = Number(oldsub) - Number(newtotal);
                                 var newgtotal = Number(gtotal) - Number(comptotal);
                                 var vatTax = Number(newgtotal) / 1.12;
                                 var vatableTax = Number(vatTax) * .12;


                                 document.getElementById(qty_textbox).value = newqty;
                                 document.getElementById(newtotal_txtbox).innerHTML = newtotal.toFixed(2);
                                 document.getElementById('gtotal').value = newgtotal.toFixed(2);
                                 document.getElementById('vattax').innerHTML = vatableTax.toFixed(2);
                                 document.getElementById('vatabletax').innerHTML = vatTax.toFixed(2);
                            });
                        </script>
<?php
                    }

                    elseif($rqty > $originalquantity)
                    {
                        $results = $rqty - $originalquantity;

                        $update_cart = mysql_query("UPDATE cart SET item_qty = '$rqty'
                                        WHERE item_num = '$itemnumber' and customer_num ='".$_SESSION['user_id']."'")
                                        or die (mysql_error());

                        $add_stocks = mysql_query("UPDATE item 
                                        SET item_itemonhand = (item_itemonhand - $results) WHERE item_num = '$itemnumber'")
                                        or die (mysql_error());
?>
                        <script type="text/javascript">
                                 var itemprice = "<?php echo $res['item_price'];?>";
                                 var newqty = "<?php echo $newqty;?>";
                                 var qty_textbox = "<?php echo $holdersatxtbox;?>";
                                 var newtotal_txtbox = "<?php echo $holdersanewtotal;?>";
                                 var subtotal_txtbox = "<?php echo $holdersasubtotalhidden?>";
                                 var newtotal = itemprice * newqty;
                                 var oldsub = document.getElementById(subtotal_txtbox).value;

                            $(window).load(function(){
                            swal("Done", "You added a quantity to order", "success");

                                 var gtotal = document.getElementById('gtotal').value;
                                 var comptotal = Number(newtotal) - Number(oldsub);
                                 var newgtotal = Number(gtotal) + Number(comptotal);
                                 var vatTax = Number(newgtotal) / 1.12;
                                 var vatableTax = Number(vatTax) * .12;

                                 document.getElementById(qty_textbox).value = newqty;
                                 document.getElementById(newtotal_txtbox).innerHTML = newtotal.toFixed(2);
                                 document.getElementById('gtotal').value = newgtotal.toFixed(2);
                                 document.getElementById('vattax').innerHTML = vatableTax.toFixed(2);
                                 document.getElementById('vatabletax').innerHTML = vatTax.toFixed(2);
                        });
                        </script>
<?php
                            

                    }
                   
                }
        //****************************************************************************************
        //****                      DELETE STARTS HERE                                         ***
        //****************************************************************************************

                if(isset($_POST["$holdersadelete"]))
                {
?>
                    <script type="text/javascript">
                    var itemnum = "<?php echo $res['item_num'];?>";
                    var cus_num = "<?php echo $_SESSION['user_id'];?>";
                          $(window).load(function(){

                            swal({   
                                title: "Are you sure?",   
                                text: "You will not be able to recover this item!",   
                                type: "warning",   
                                showCancelButton: true,   
                                confirmButtonColor: "#DD6B55",   
                                confirmButtonText: "Yes, delete it!",   
                                cancelButtonText: "No, cancel pls!",   
                                closeOnConfirm: false,   
                                closeOnCancel: false 
                            }, function(isConfirm){   
                                if (isConfirm) {  
                                    $.post("delcartitem.php",{itemnum : itemnum, cusnum : cus_num}, function(data){
                                        if(data == "success")
                                        {
                                            swal("Deleted!", "Your selected item has been deleted.", "success");
                                          
                                                    window.location.href='viewcart.php';
                                                
                                        }
                                        else if(data == "error")
                                        {
                                            swal("Cancelled", "Error Deleting item on cart :(", "error");
                                        }
                                        else
                                        {
                                            swal("Cancelled", "Error Deleting item on cart :((", "error");
                                        }
                                    });
                                       
                                } else {     
                                    swal("Cancelled", "Your Item is not deleted :)", "error");   
                                } 
                            });
                        });
                    
                    </script>
<?php
                }


                $gtotal += $res['subtotal'];
                $vatTax  = $gtotal / 1.12 * 0.12;
                $vaTable = $gtotal - $vatTax;
               
            }
          

            echo '<div class="lv-item media">
                 
                    <div class="media-body" style="float: right">
                        <table>
                            <tr>
                                <td><small style="padding-right: 10px;">Total</small></td>
                                <td><small style="font-weight: bold"><input type="text" style="border-color:#fff;border-style:solid;" id="gtotal" value="'. number_format($gtotal, 2) .'"></small></td>
                            </tr>
                            <tr>
                                <td><small style="padding-right: 10px;">Vat Tax</small></td>
                                <td><small style="font-weight: bold"><label id="vattax">'. number_format($vatTax, 2) .'</label></small></td>
                            </tr>
                            <tr>
                                <td><small style="padding-right: 10px;">VATable</small></td>
                                <td><small style="font-weight: bold"><label id="vatabletax">'. number_format($vaTable, 2) .'</label></small></td>
                            </tr>
                        </table><br>
                        <button type="submit" name="proceed" class="btn bgm-deeporange waves-effect">
                            Proceed
                            <i class="zmdi zmdi-arrow-forward"></i>
                        </button>
                    </div>
                 </div>';  
    
         if(isset($_POST["proceed"]))
            {
                $_SESSION["vatabletax"] = $vatTax;
                $_SESSION["grandtotal"]= $gtotal;

                if($gtotal <= 1000)
                {
?>
                    <script type="text/javascript">  
                      $(window).load(function(){
                            swal("Total amount must be greater than 1000 pesos")
                        });
                    </script>
<?php
                }
                else
                {
                    echo "<script>window.location='rtype.php'</script>";
                }
            }
    }
?>