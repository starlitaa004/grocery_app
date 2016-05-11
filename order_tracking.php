<?php require_once('header.php'); ?>
<?php
    function ordernumber(){
     $current_cusid = $_SESSION['user_id'];
     $select_orders = mysql_query("SELECT order_master.*, recievetype.*,customer.*, recievetype_details.status  
                    FROM order_master INNER JOIN recievetype ON 
                    order_master.om_receivetypeno = recievetype.receivetypeNo 
                    INNER JOIN recievetype_details ON recievetype_details.or_num = order_master.om_orno 
                    INNER JOIN customer ON order_master.om_cusno = customer.customer_num
                    WHERE recievetype_details.status != 'success' AND customer.customer_num = '$current_cusid'");

        while ($rows_fetch = mysql_fetch_assoc($select_orders)) {
            echo "<option>OR-2016-". $rows_fetch['om_orno'] . "</option>";
        }
    }
?>
<?php
    function showStatus()
    {
        if(isset($_POST["myfield"]))
        {
            $ordernumber = mysql_real_escape_string($_POST['myfield']);

            $ordernumbers = substr($ordernumber,8);
            
                
                $select_status = mysql_query("SELECT * FROM recievetype_details WHERE or_num = '$ordernumbers'");
                $fetch_status = mysql_fetch_assoc($select_status);

                if($fetch_status['status'] == "on process")
                {

                  echo'<br>
                    <br>
                    <h3>OR NUMBER :'. $ordernumber . '</h3>
                    <font color="red"><h4>Is still ON PROCESS</h4></font><br><br>

                    <img class="form-control" src="/grocery/www/assets/img/onprocess.png" alt="" style="height:20%;">
                    <br>
                    <br>
                    <br>';
                }

                elseif ($fetch_status['status'] == "Order Validated") 
                {
      
                    echo'<br>
                    <br>
                    <h3>OR NUMBER :' . $ordernumber . '></h3>
                    <font color="red"><h4>is already VALIDATED</h4></font><br><br>

                    <img class="form-control" src="/grocery/www/assets/img/validated.png" alt="" style="height:20%;">
                    <br>
                    <br>
                    <br>';
    
                }

                elseif($fetch_status['status'] == "Success")
                {
                    echo'<br>
                    <br>
                    <h3>OR NUMBER :' . $ordernumber . '</h3>
                    <font color="red"><h4>Thank You for shopping ! :) Hope to see you again.</h4></font><br><br>

                    <img class="form-control" src="/grocery/www/assets/img/success.png" alt="">
                    <br>
                    <br>
                    <br>';

                }
        }

    }
?>
<form method="POST" action="order_tracking.php">
<div class="container">
    <div class="block-header">
        <h2>ORDER TRACKING<small>Please select an order number to view status</small></h2>
    </div>                   
   
    <div class="card">
        <div class="card-body card-padding" id="ordertrack">
        <div class="fg-line">
            <div class="select">
                <select class="form-control" name="myfield" onchange="this.form.submit()">
                    <option>--CHOOSE--</option>
                <?php
                   ordernumber();
                ?>
                </select>
                <noscript><input type="submit" value="Submit" name="trythis"></noscript>
            </div>
        </div>
            <?php
                showStatus();
            ?>
        </div>
    </div>
      
</div>  
<?php require_once('footer.php'); ?>
            