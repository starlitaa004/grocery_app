<?php require_once('header.php'); ?>
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

<?php
    function loadproducts() {
        if(isset($_GET['storeid']) && isset($_GET['category']) && isset($_GET['limit'])) {
            $storeid    = $_GET['storeid'];
            $limit      = $_GET['limit'];
            $category   = $_GET['category'];

            $_SESSION['storeid']  = $_GET['storeid'];
            $_SESSION['limit']    = $_GET['limit'];
            $_SESSION['category'] = $_GET['category'];
            
            $query = mysql_query("SELECT item_num, item_desc, item_price, item_unit, item_itemonhand, item_cat, item_expdate, nutri_facts FROM `item` WHERE item_itemonhand != 0 AND storeid = ". $storeid ." AND item_cat = '". $category ."' LIMIT ". $limit);
            $numrows = mysql_num_rows($query);


            if($numrows != 0) {
                while($row = mysql_fetch_assoc($query)) {
                    echo '<div class="lv-item media">
                            <div class="pull-left">
                                <img style="width: 70px; height: 70px" class="lv-img-sm" src="/groceryadmin/html/images/'. $row['item_num'] .'.png" alt="">
                            </div>
                            <div class="media-body">
                                <div class="lv-title"><h5><b>'. $row['item_desc'] .'</b></h5></div>
                                <small>'. $row['nutri_facts'] .'</small>
                                <div style="padding-top: 10px;">
                                    <form method="post" action="cart.php?item_num='. $row['item_num'] .'">
                                        <input type="text" name="item_num" value="'. $row['item_num'] .'" hidden>
                                        Qty: <input type="number" style="width:50px" min="1" max="'. $row['item_itemonhand'] .'" name="qty" value="1">
                                        <button type="submit" name="addtocart" class="btn bgm-amber waves-effect"><i class="zmdi zmdi-local-grocery-store"></i></button><br>
                                        <small>Price: '. $row['item_price'] .'</small><br>
                                        <small>Stocks: '. $row['item_itemonhand'] .'</small>
                                    </form>
                                </div>
                                                            
                                <div class="lv-actions actions dropdown">
                                    <a href="" data-toggle="dropdown" aria-expanded="true">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="productdetails.php?item_num='. $row['item_num'] .'">Details</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>';
                }
        ?>
                <div class="load-more" style="padding-bottom: 15px">
                    <a href="cart.php?storeid=<?php echo $storeid; ?>&limit=<?php echo $limit + 2; ?>&category=<?php echo $category; ?>"><i class="zmdi zmdi-refresh-alt"></i> Load More...</a>
                </div>
        <?php
            } else {
                echo "No Products";
            }
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
	<a href="categories.php?storeid=<?php echo $_SESSION['storeid']; ?>">
        <button class="btn btn-primary waves-effect waves-float">
            <small style="font-size:8px;">Categories</small>
        </button>
    </a>
		<div class="card">
            <div class="listview lv-bordered lv-lg">
                <div class="lv-header-alt clearfix">
                    <h2 class="lvh-label hidden-xs">Some text here</h2>
                    
                    <div class="lvh-search">
                        <input type="text" placeholder="Product Name..." class="lvhs-input">
    
                        <i class="lvh-search-close">×</i>
                    </div>
                    
                    <ul class="lv-actions actions">
                        <li>
                            <a href="" class="lvh-search-trigger">
                                <i class="zmdi zmdi-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="lv-body">
					<?php loadproducts(); ?>  
				</div>
            </div>
        </div>
	</div>
</div>
<?php require_once('footer.php'); ?>
<?php
    if(isset($_POST['addtocart'])) {
        if(!(isset($_SESSION['user_id']))) {
            echo "<script language='javascript'>window.location = ['login.php']</script>";
        } else {
            $user_id = $_SESSION['user_id'];
        }

        if(isset($_POST['item_num']) && isset($_POST['qty']) && isset($_SESSION['user_id'])) {
            $item_num = $_GET['item_num'];
            $qty      = $_POST['qty'];
            
            $check = mysql_query("SELECT * FROM cart WHERE customer_num = ". $user_id ." AND item_num = ". $item_num);
            $numrows = mysql_num_rows($check);

            if($numrows != 0) {
                $update_cart = mysql_query("UPDATE cart SET item_qty = item_qty + ". $qty ." WHERE customer_num = ". $user_id ." AND item_num = ". $item_num);
                $_SESSION['msg'] = "add to cart";
                echo "<script language='javascript'>window.location = ['cart.php?storeid=". $_SESSION['storeid'] ."&limit=". $_SESSION['limit'] ."&category=". $_SESSION['category'] ."']</script>";
            } else {
                $query = mysql_query("INSERT INTO cart(`customer_num`,`item_num`,`item_qty`)  VALUES('$user_id','$item_num','$qty')");
                $_SESSION['msg'] = "add to cart";
                echo "<script language='javascript'>window.location = ['cart.php?storeid=". $_SESSION['storeid'] ."&limit=". $_SESSION['limit'] ."&category=". $_SESSION['category'] ."']</script>";
            }
            // Subtract item quantity once the customer order the item
            $query = mysql_query("UPDATE `item` SET item_itemonhand = item_itemonhand - ". $qty ." WHERE item_num = ". $item_num);
        }
    }
?>
<?php
    if(isset($_SESSION['msg'])) {
        if($_SESSION['msg'] == "add to cart") {
            require_once('msg.js');
        }
        $_SESSION['msg'] == "";
    }
?>