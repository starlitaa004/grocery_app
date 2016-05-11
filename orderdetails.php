<?php require_once('header.php'); ?>
<?php
    function orderDetails()
    {
            $om_orno = $_GET['om_orno'];
            $select_orders = mysql_query("SELECT item.item_desc, item.item_num,item.item_cat,item.item_itemonhand,item.item_price,order_details.od_qty,order_master.om_vat,order_master.storeid,order_details.od_subprice
                            FROM order_master INNER JOIN (item INNER JOIN order_details ON item.item_num = order_details.od_itemno) 
                            ON order_master.om_orno = order_details.od_orno WHERE order_details.od_orno = '$om_orno'") or die (mysql_error());
            $numberrows = mysql_num_rows($select_orders);
            $gtotal  = 0;
            $vatTax  = 0;
            $vaTable = 0;
            if($numberrows != 0) {

            while($result = mysql_fetch_assoc($select_orders)) {
                echo '<div class="lv-item media">
                            <div class="media-body">
                                <div class="lv-title"><h5><b>'. $result['item_desc'] .'</b></h5></div>
                                <div style="padding-top: 10px;">
                                    <form method="post" action="viewcart.php?item_num='. $result['item_num'] .'">
                                        <small>Price: '. $result['item_price'] .'<span style="padding-left: 5px; padding-right: 5px;color:red"> x </span><label>'. $result['od_qty'] .'</label><span style="padding-left: 5px; padding-right: 5px;color:red"> = </span>
                                            <span style="padding-right: 10px; font-weight: bold">'. number_format($result['od_subprice'], 2) .'</span>
                                        </small><br>
                                </div>
                            </div>
                        </div>';
               
                $gtotal += $result['od_subprice'];
                $vatTax  = $gtotal / 1.25 * 0.12;
                $vaTable = $gtotal - $vatTax;
                
            }
          

            echo '<div class="lv-item media">
                 
                    <div class="media-body" style="float: right">
                        <table>
                            <tr>
                                <td><small style="padding-right: 10px;">Total</small></td>
                                <td><small style="font-weight: bold">'. number_format($gtotal, 2) .'</small></td>
                            </tr>
                            <tr>
                                <td><small style="padding-right: 10px;">Vat Tax</small></td>
                                <td><small style="font-weight: bold">'. number_format($vatTax, 2) .'</small></td>
                            </tr>
                            <tr>
                                <td><small style="padding-right: 10px;">VATable</small></td>
                                <td><small style="font-weight: bold">'. number_format($vaTable, 2) .'</small></td>
                            </tr>
                        </table><br>
                    </div>
                 </div>';  
        }
    }
?>
<div class="container">
    <div class="block-header">
        <h2>Products under OR : <strong> OR-2016-<?php echo $_GET['om_orno']; ?> </strong></h2>
    </div>                   
   
    <div class="card">
         <div class="listview lv-bordered lv-lg">
          <?php
                orderDetails();
          ?>
        </div>
    </div>
                        
    </div>
      
</div>  
<?php require_once('footer.php'); ?>
            