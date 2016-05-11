<?php require_once('header.php'); ?>
<?php
    include 'dbconnection.php';
    
    function loadstore() {
        $query = mysql_query("SELECT * FROM storeinfo");
        $numrows = mysql_num_rows($query);

        if($numrows != 0) {
            while($row = mysql_fetch_assoc($query)) {
                echo '<div class="col-md-2 col-sm-4 col-xs-12"> 
                        <div class="c-item">
                            <a href="" class="ci-avatar"> 
                            <img src="assets/img/'. $row['storeid'] .'.jpg"></a>

                            <div class="c-info">
                                <strong>'. $row['storename'] .'</strong>
                                <small>'. $row['storelocation'] .'</small>
                                <small>'. $row['storecontact'] .'</small>
                            </div>

                            <div class="c-footer">
                                <button class="waves-effect">
                                    <a href="categories.php?storeid='. $row['storeid'] .'">Start Your Order</a>
                                </button>
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
        <h2>GROCERY APP<small>Please select a store to start your order</small></h2>
    </div>                   
    <div class="card">                        
        <div class="card-body card-padding">
            <div id="storeinfo" class="contacts clearfix row">
               <!-- STORE INFORMATION GOES HERE :) PLEASE SEE loadStore()  in groceryapp.js --> 
               <?php loadstore(); ?>
            </div>
        </div>
    </div>
</div>  
<?php require_once('footer.php'); ?>
            