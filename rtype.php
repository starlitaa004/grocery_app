<?php require_once('header.php'); ?>
<?php $vatable = $_SESSION["vatabletax"];?>
<div class="container">                  
   <!-- <button class="btn bgm-lightgreen waves-effect"><i class="zmdi zmdi-menu"></i></button> -->
   <form method="POST" action="rtype.php">
    <div class="card">
        <div class="card-body card-padding" id="ordertrack">
         <center>
        <h4>CHOOSE PAYMENT OPTION</h4> <BR>
             <label class="radio radio-inline m-r-20">
                <input type="radio" name="rtype" value="RT-101">
                <i class="input-helper"></i>  
                PICK UP
            </label>
            
            <label class="radio radio-inline m-r-20">
                <input type="radio" name="rtype" value="RT-102">
                <i class="input-helper"></i>  
                CASH ON DELIVERY
            </label>
            <br><br><br><br>
             <button type="submit" name="proceed" class="btn bgm-deeporange waves-effect">
                Proceed
                <i class="zmdi zmdi-arrow-forward"></i>
             </button>
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
        $rtype = $_POST["rtype"];
        $customernumber = $_SESSION['user_id'];
        $store_id = $_SESSION['storeid'];

        if($rtype == "RT-101")
        {
            $insert_order = mysql_query("INSERT INTO order_master(`om_orno`, `om_cusno`, `om_empno`, `om_vat`, `om_receivetypeno`, `storeid`, `om_deliverypayment`)
                                    VALUES('$ordernumber'+1,'$customernumber','','$vatable','RT-101','$store_id','')") or die (mysql_error());

            $insert_status = mysql_query("INSERT INTO `recievetype_details`(`receivetypeno`, `deliverydate`, `or_num`, `status`) 
                                        VALUES('RT-101','','$ordernumber'+1,'on process')") or die (mysql_error());
                                            
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
$message = "GROCERY APPLICATION : Your order OR-2016-". $ordernumberforsend." has been received and is going through verification process. You can track your order at your mobile app using the order tracking found on the menu. Thank you for shopping!";
$debug = true;

ozekiSend($phonenum,$message,$debug);

}
#****************************************************************************************************
#                       END OF PICKUP DELIVERY // FUNCTION FRO DELIVERY RADIOBUTTON           *******
#****************************************************************************************************

        if($rtype == "RT-102")
        {
            echo "<script>window.location='delivery.php'</script>";
        }
       
    }
?>

            