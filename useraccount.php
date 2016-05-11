<?php require_once('header.php'); ?>
<div class="container">                  
   <!-- <button class="btn bgm-lightgreen waves-effect"><i class="zmdi zmdi-menu"></i></button> -->
   <form method="POST" action="useraccount.php">
       <section id="content">
        <div class="container">
            <div class="block-header">
                <h2><?php
                        $select_name=mysql_query("SELECT * FROM useraccount WHERE user_id='".$_SESSION['user_id']."'");
                        $fetch_name = mysql_fetch_assoc($select_name);

                        $select_gender=mysql_query("SELECT * FROM customer WHERE customer_num='".$_SESSION['user_id']."'");
                        $fetch_gender = mysql_fetch_assoc($select_gender);

                ?></h2>
            </div>
            
            <div class="card" id="profile-main">
                        <div class="pmo-pic">
                        <div class="p-relative">
                            <center>
                                <a href="">
                                    <?php
                                    if($fetch_gender['customer_gender'] == "female")
                                    {
                                        echo'<img class="img-responsive mCS_img_loaded" src="/grocery/www/assets/img/profile.jpg" alt="">';
                                    }
                                    else
                                    {
                                        echo'<img class="img-responsive mCS_img_loaded" src="/grocery/www/assets/img/avatar5.png" alt="">';
                                    }
                                ?>
                                </a>
                            </center>
                        </div>
                <div id="mCSB_3_scrollbar_vertical" class="mCSB_scrollTools mCSB_3_scrollbar mCS-minimal-dark mCSB_scrollTools_vertical" style="display: block;">
                </div><div id="mCSB_3_scrollbar_horizontal" class="mCSB_scrollTools mCSB_3_scrollbar mCS-minimal-dark mCSB_scrollTools_horizontal" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_3_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 50px; width: 0px; left: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar"></div></div><div class="mCSB_draggerRail"></div></div></div></div>
                
                <div class="pm-body clearfix">
                    <ul class="tab-nav tn-justified">
                        <li class="waves-effect"><a href="profile.php">About</a></li>
                        <li class="active waves-effect"><a href="useraccount.html">User Account</a></li>
                    </ul>
                    
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-5"></i> User Account</h2>
                            
                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>
                                    
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-pmb-action="edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>Username</dt>
                                    <dd><?php echo $fetch_name['uname']; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Password</dt>
                                    <dd>*********</dd>
                                </dl>
                                 <dl class="dl-horizontal">
                                    <dt>Account Type</dt>
                                    <dd>Customer</dd>
                                </dl>
                                
                            </div>
                            
                            <div class="pmbb-edit">
                              
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Username</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="uname" class="form-control" value="<?php echo $fetch_name['uname'];?>">
                                        </div>
                                        
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Password</dt>
                                    <dd>
                                        <div class="dtp-container dropdown fg-line">
                                            <input type="text" class="form-control" name="pword" value="<?php echo $fetch_name['pword'];?>">
                                        </div>
                                    </dd>
                                </dl>
                              
                                <div class="m-t-30">
                                    <button type="submit" name="savebtn" class="btn btn-primary btn-sm waves-effect">Save</button>
                                    <button data-pmb-action="reset" class="btn btn-link btn-sm waves-effect">Cancel</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
               
                </div>
            </div>
        </div>
    </section>  

<?php require_once('footer.php'); ?>   

 <?php
    if(isset($_POST["savebtn"]))
    {
        $uname = $_POST["uname"];
        $pword = $_POST["pword"];
        
        $update_account = mysql_query("UPDATE useraccount SET 
                        uname='$uname', pword='$pword' 
                        WHERE user_id = '" .$_SESSION['user_id']. "'") or die(mysql_error());
?>
         <script type="text/javascript">  
                      $(window).load(function(){
                         swal("Good job!", "You successfully updated your Information!", "success")
                    });

        </script>
<?php
    }
?>   
