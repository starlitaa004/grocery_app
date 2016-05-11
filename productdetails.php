<?php require_once('header.php'); ?>
<?php
    include 'dbconnection.php';

    function productdetails() {
        $item_num = $_GET['item_num'];
    
        $query = mysql_query("SELECT item_num, item_desc, item_price, item_unit, item_itemonhand, item_cat, item_expdate, nutri_facts 
                              FROM `item` WHERE item_num = ". $item_num);
        $numrows = mysql_num_rows($query);

        if($numrows != 0) {
            while($row = mysql_fetch_assoc($query)) {
                echo '<div class="col-md-2 col-sm-4 col-xs-12"> 
                        <div class="c-item">
                            <a href="" class="ci-avatar"> 
                            <img src="/groceryadmin/html/images/'. $row['item_num'] .'.png"></a>

                            <div class="c-info">
                                <table>
                                    <tr>
                                        <td><small>Item Name</small></td>
                                        <td><strong>: '. $row['item_desc'] .'</strong></td>
                                    </tr>
                                    <tr>
                                        <td><small>Price</small></td>
                                        <td><small>: '. $row['item_price'] .'</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Unit</small></td>
                                        <td><small>: '. $row['item_unit'] .'</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Stocks</small></td>
                                        <td><small>: '. $row['item_itemonhand'] .'</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Expiration Date</small></td>
                                        <td><small>: '. $row['item_expdate'] .'</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Category</small></td>
                                        <td><small>: '. $row['item_cat'] .'</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Nutritional Facts:</small></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><small></small></td>
                                        <td><small>'. $row['nutri_facts'] .'</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            $store = "no store";
        }
    }
?>
<div class="container">
    <div class="block-header">
        <h2>GROCERY APP<small>Product Details</small></h2>
    </div>                   
    <div class="card">                        
        <div class="card-body card-padding">
            <div id="storeinfo" class="contacts clearfix row">
               <?php productdetails(); ?>
            </div>
        </div>
    </div>
</div>  
<?php require_once('footer.php'); ?>