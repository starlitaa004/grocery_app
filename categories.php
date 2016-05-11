<?php require_once('header.php'); ?>
<?php
    include 'dbconnection.php';
    
    function loadcategories() {
        $_SESSION['storeid'] = $_GET['storeid'];
        $storeid    = $_GET['storeid'];

        $query = mysql_query("SELECT DISTINCT item_cat FROM item WHERE storeid='$storeid'");
        $numrows = mysql_num_rows($query);

        if($numrows != 0) {
            while($row = mysql_fetch_assoc($query)) {
                echo '<div class="lv-item media">
                        <div class="pull-left">
                            <img onclick=\'showcat("'. strtolower($row['item_cat']) .'")\' class="lv-img-sm" src="assets/categories/'. strtolower(preg_replace("' '", '_', $row['item_cat'])) .'.jpg" alt="">
                        </div>
                        <div class="media-body">
                             <a href="cart.php?storeid='. $_SESSION['storeid'] .'&limit=2&category='. $row['item_cat'] .'">
                                <div class="lv-title"><h5>'. $row['item_cat'] .'</h5></div>
                             </a>                       
                            <div class="lv-actions actions dropdown">
                                <a href="" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="cart.php?storeid='. $_SESSION['storeid'] .'&limit=2&category='. $row['item_cat'] .'">Show Products</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo "No Categories";
        }
    }
?>
<div class="container">
    <div class="block-header">
        <h2>GROCERY APP<small>Below are the list of Categories</small></h2>
    </div>                   
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
                <?php loadcategories(); ?>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>

<script type="text/javascript">
	function showcat(item_cat) {
		swal({
		        title: item_cat,
		        imageUrl: 'assets/categories/' + item_cat.replace(' ', '_') + '.jpg',
		    });
	}
</script>