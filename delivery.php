<?php require_once('header.php'); ?>
<?php $vatable = $_SESSION["vatabletax"];
      $grandtotal = $_SESSION["grandtotal"];
    ?>

<?php
    function delivery()
    {
        date_default_timezone_set("Asia/Manila");
        $min = date("m-d-Y");
        $day = date("d");
        $dayadded= $day + 3;
        $max = date("Y-m-$dayadded");

        //echo "<h3>TOTAL : " . $grandtotal . "</h3>";
        echo'   <h4>Date of delivery</h4>
                <small>This only allows you to order today until the next 3 days</small><br><br>
                <input type="date" name="deldate" placeholder="Click here..." class="form-control input-mask" date-mask="00/00/00"
                min="'. date("Y-m-d") .'" max="'. $max . '?>" required="required">
                <br>
                <h4>Please input amount of money to pay</h4>
                    <div class="input-group fg-float">
                        <div class="fg-line">
                            <input type="number" name="payment" min="1" class="form-control" required="required">
                        </div>
                    </div>
                <br>
                <h4>Place of Delivery</h4>
                <input type="text" name="placeofdelivery" class="form-control" required="required">
                <br>
                <h4>Landmark</h4>
                <input type="text" name="landmark" class="form-control" required="required">
                <br>

            <button type="submit" name="proceed" class="btn bgm-deeporange waves-effect" style="float:right;">
                Submit Order
                <i class="zmdi zmdi-arrow-forward"></i>
            </button>';
    }
?>
<div class="container">                  
   <form method="POST" action="delivery.php">
    <div class="card">
        <div class="card-body card-padding" id="ordertrack">
          <?php
            echo delivery();
          ?>
           <!--DI NALANG KO MAG SET OG TIME OY BASTA ANG DELIVERY IS WITHIN THE DAY 
                AND WITHIN THE STORE HOURS-->
        </div>
    </div> 
</div>  

<?php require_once('footer.php'); ?>
<?php
    if(isset($_POST["proceed"]))
    {
        $desc_ornum = mysql_query("SELECT om_orno FROM order_master ORDER BY 1 DESC");
        $fetch_ornum = mysql_fetch_assoc($desc_ornum);

        $ordernumber = $fetch_ornum['om_orno'];
        $customernumber = $_SESSION['user_id'];
        $store_id = $_SESSION['storeid'];
        $deliverydate = $_POST['deldate'];
        $payment = $_POST['payment'];
        $remarks = $_POST['placeofdelivery'] . " " . $_POST['landmark'];

        if($payment >= $grandtotal)
        {
            $insert_order = mysql_query("INSERT INTO `order_master`(`om_orno`, `om_cusno`, `om_empno`, `om_vat`, `om_receivetypeno`, `storeid`, `om_deliverypayment`) 
                                                VALUES('$ordernumber'+1,'$customernumber','','$vatable','RT-102','$store_id','$payment')") or die (mysql_error());

            $insert_status = mysql_query("INSERT INTO `recievetype_details`(`receivetypeno`, `deliverydate`, `or_num`, `status`,`remarks`) 
                                        VALUES('RT-102',now(),'$ordernumber'+1,'on process','$remarks')") or die (mysql_error());  

            $import_cart = mysql_query("SELECT cart.*, item.item_price FROM cart
                                        INNER JOIN item ON cart.item_num = item.item_num
                                        WHERE customer_num = '$customernumber'") or die (mysql_error());
            while($fetch_cart = mysql_fetch_assoc($import_cart))
            {
                $itemnumber = $fetch_cart["item_num"];
                $itemqty = $fetch_cart["item_qty"];
                $itemprice = $fetch_cart["item_price"];
                $subprice = $itemqty * $itemprice;
                $insert_orderdetails = mysql_query("INSERT INTO `order_details`(`od_orno`, `od_itemno`, `od_qty`, `od_subprice`) 
                                                VALUES('$ordernumber'+1,'$itemnumber','$itemqty','$subprice')") or die (mysql_error());   
            }   
            
            $delete_cart = mysql_query("DELETE FROM cart WHERE customer_num='$customernumber'");
    ?>
             <script type="text/javascript">  
                      $(window).load(function(){
                         swal("Done!", "Your order is already on process", "success")
                         //window.location='order_tracking.php';
                    });
            </script>
<?php

###########################################################################################################
##               Still inside PICKUP option, Drei mag start ang function nga para send message          ##
###########################################################################################################
$ozeki_user = "admin";
$ozeki_password = "admin";
$ozeki_url = "http://127.0.0.1:9501/api?";


########################################################
# Functions used to send the SMS message
########################################################
function httpRequest($url){
    $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
    preg_match($pattern,$url,$args);
    $in = "";
    $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
    if (!$fp) {
       return("$errstr ($errno)");
    } else {
        $out = "GET /$args[3] HTTP/1.1\r\n";
        $out .= "Host: $args[1]:$args[2]\r\n";
        $out .= "User-agent: Ozeki PHP client\r\n";
        $out .= "Accept: */*\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);
        while (!feof($fp)) {
           $in.=fgets($fp, 128);
        }
    }
    fclose($fp);
    return($in);
}



function ozekiSend($phone, $msg, $debug=false){
      global $ozeki_user,$ozeki_password,$ozeki_url;

      $url = 'username='.$ozeki_user;
      $url.= '&password='.$ozeki_password;
      $url.= '&action=sendmessage';
      $url.= '&messagetype=SMS:TEXT';
      $url.= '&recipient='.urlencode($phone);
      $url.= '&messagedata='.urlencode($msg);

      $urltouse =  $ozeki_url.$url;
      if ($debug) { echo "<label style='display:none;'> Request: <br>$urltouse<br><br>"; }

      //Open the URL to send the message
      $response = httpRequest($urltouse);
      if ($debug) {
           echo "<label style='display:none;'>Response: <br><pre>".
           str_replace(array("<",">"),array("&lt;","&gt;"),$response).
           "</pre><br>"; }

      return($response);
}

########################################################
# GET data from sendsms.html
########################################################

$select_contact = mysql_query("SELECT * FROM customer WHERE customer_num = '$customernumber'");
$fecth_cont = mysql_fetch_assoc($select_contact);
$contactnumber = $fecth_cont['customer_contact'];

$ordernumberforsend = $ordernumber + 1;

$phonenum = $contactnumber;
$message = "GROCERY APPLICATION : Your order OR-2016-". $ordernumberforsend." has been received and is going through verificatio process. You can track your order at your mobile app using the order tracking found on the menu. Thank you for shopping!";
$debug = true;

ozekiSend($phonenum,$message,$debug);


        }
        else
        {
    ?>

        <script type="text/javascript">  
                      $(window).load(function(){
                        swal("Please input a payment that is exact or more than total amount")
                    });
        </script>
    <?php
        }
    }
?>
