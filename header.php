<?php session_start(); ?>
<?php
    include 'dbconnection.php';

    function cartnotification() {
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $query = mysql_query("SELECT COUNT(*) AS cart_items FROM cart WHERE customer_num = ". $user_id);
            $numrows = mysql_num_rows($query);
    ?>
        <a data-toggle="dropdown" href="">
            <i class="tm-icon zmdi zmdi-local-grocery-store"></i>
            <i class="tmn-counts">
                <?php 
                    if($numrows != 0) {
                        $row = mysql_fetch_assoc($query);
                        echo $row['cart_items'];
                    } else {
                        echo "";
                    }
                ?>
            </i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg pull-right">
            <div class="listview">
                <div class="lv-header">
                    Cart
                </div>
                <div class="lv-body">
                    <?php 
                        $getitem = mysql_query("SELECT i.item_num, i.item_desc, c.item_qty FROM item i, cart c WHERE i.item_num = c.item_num AND c.customer_num = ". $user_id);
                        $num_rows = mysql_num_rows($getitem);

                        if($num_rows != 0) {
                            while($res = mysql_fetch_assoc($getitem)) {
                                echo '<a class="lv-item" href="">
                                        <div class="media">
                                            <div class="pull-left">
                                                <img class="lv-img-sm" src="/groceryadmin/html/images/'. $res['item_num'] .'.png" alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="lv-title">'. $res['item_desc'] .'</div>
                                                <small class="lv-small">Quantity: '. $res['item_qty'] .'</small>
                                            </div>
                                        </div>
                                    </a>';
                            }
                        }
                    ?>
                </div>

                <a class="lv-footer" href="viewcart.php">View All</a>
            </div>
        </div>
    <?php   }
    }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes, width=device-width" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grocery App</title>

        <!-- Vendor CSS -->
        <link href="assets/css/fullcalendar.min.css" rel="stylesheet">
        <link href="assets/css/animate.min.css" rel="stylesheet">
        <link href="assets/css/sweet-alert.css" rel="stylesheet">
        <link href="assets/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">        
        <link href="assets/css/bootstrap-select.css" rel="stylesheet">        
        <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">        
        <link href="assets/css/jquery.bootgrid.min.css" rel="stylesheet">        
            
        <!-- CSS -->
        <link href="assets/css/style1.min.css" rel="stylesheet">
        <link href="assets/css/style2.min.css" rel="stylesheet">
</head>
<body>
     <header id="header" class="clearfix" data-current-skin="blue">
            <ul class="header-inner">
                <li class="pull-left">
                    <ul class="top-menu">
                        <li>
                            <a href="index.php"><i class="tm-icon zmdi zmdi-home"></i></a>
                        </li>
                        <li>
                            <a href="purchasedhistory.php"><i class="tm-icon zmdi zmdi-local-library"></i></a>
                        </li>
                        <li>
                            <a href="order_tracking.php"><i class="tm-icon zmdi zmdi-local-shipping"></i></a>
                        </li>
                        <li class="dropdown">
                            <?php cartnotification(); ?>
                        </li>
                    </ul>
                </li>
                <li class="pull-right">
                    <ul class="top-menu">
                        <li class="dropdown">
                            <a data-toggle="dropdown" href=""><i class="tm-icon zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                <?php
                                    if(isset($_SESSION['user_id'])) {
                                        echo '<li>
                                                <a href="profile.php"><i class="zmdi zmdi-face"></i> Profile</a>
                                              </li>
                                              <li>
                                                <a href="logout.php"><i class="zmdi zmdi-settings"></i> Logout </a>
                                              </li>';
                                    } else {
                                        echo '<li>
                                                <a href="login.php"><i class="zmdi zmdi-settings"></i> Login </a>
                                              </li>';
                                    }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>

     <section id="main" data-layout="layout-1">
            <aside id="sidebar" class="sidebar c-overflow mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar" style="overflow: visible;">
                <div id="mCSB_1" class="mCustomScrollBox mCS-minimal-dark mCSB_vertical_horizontal mCSB_outside" tabindex="0">
                    <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y mCS_x_hidden mCS_no_scrollbar_x" style="position: relative; top: 0px; left: 0px; width: 100%;" dir="ltr">
                    </div>
            </aside>
    <section id="content">