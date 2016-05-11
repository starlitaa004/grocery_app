<?php require_once('header.php'); ?>
<?php
    function loadOrders()
    {
        $user_id = $_SESSION['user_id'];
        $phistory = mysql_query("SELECT order_master.*, recievetype.*,customer.*, employee.*,recievetype_details.status,recievetype_details.accepted_date  
        FROM order_master INNER JOIN recievetype ON 
        order_master.om_receivetypeno = recievetype.receivetypeNo 
        INNER JOIN recievetype_details ON recievetype_details.or_num = order_master.om_orno 
        INNER JOIN customer ON order_master.om_cusno = customer.customer_num
        INNER JOIN employee ON order_master.om_empno = employee.emp_no
        WHERE recievetype_details.status = 'success' AND customer.customer_num = '$user_id'") or die(mysql_error());

        while($fetch= mysql_fetch_assoc($phistory)) 
        {
            echo'<div class="lv-body">
                <div class="lv-item media">
                    <div class="media-body">
                        <div class="lv-title">
                        <strong>Order Number : </strong>
                        OR-2016-'. $fetch['om_orno'] .'</div>
                        <div class="lv-body">
                        <strong>Purchased Date : </strong>
                        ' . $fetch['accepted_date'] . ' <br>
                        <strong>Received Type</strong>
                        ' . $fetch['receivetype'] . '

                        </div>
                        <div class="lv-actions actions dropdown">
                            <a href="#" data-toggle="dropdown" aria-expanded="true">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="orderdetails.php?om_orno='. $fetch['om_orno'] .'"">View</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                      </div>
            </div>';
        }
                    
    }
?>
<div class="container">
    <div class="block-header">
        <h2>History of your transaction that has been completed :</h2>
    </div>                   
   
    <div class="card">
         <div class="listview lv-bordered lv-lg">
            <?php
                loadOrders();
            ?>
              
        </div>
    </div>
                        
    </div>
      
</div>  
<?php require_once('footer.php'); ?>
            