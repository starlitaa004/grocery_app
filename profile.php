<?php require_once('header.php'); ?>
<div class="container">                  
   <!-- <button class="btn bgm-lightgreen waves-effect"><i class="zmdi zmdi-menu"></i></button> -->
   <form method="POST" action="profile.php">
       <section id="content">
        <div class="container">
            <div class="block-header">
                <h2><?php
                        $select_name=mysql_query("SELECT * FROM customer WHERE customer_num='".$_SESSION['user_id']."'");
                        $fetch_name = mysql_fetch_assoc($select_name);

                        echo $fetch_name['customer_fname'] . " " . $fetch_name['customer_mi'] . ". " . $fetch_name['customer_lname']; 
                ?></h2>
            </div>
            
            <div class="card" id="profile-main">
                        <div class="pmo-pic">
                        <div class="p-relative">
                            <center>
                                <a href="">
                                <?php
                                    if($fetch_name['customer_gender'] == "female")
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
                        <li class="active waves-effect"><a href="profile-about.html">About</a></li>
                        <li class="waves-effect"><a href="useraccount.php">User Account</a></li>
                    </ul>
                    
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-5"></i> Basic Information</h2>
                            
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
                                    <dt>Full Name</dt>
                                    <dd><?php echo ucwords($fetch_name['customer_fname'] . " " . $fetch_name['customer_mi'] . ". " . $fetch_name['customer_lname']); ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Gender</dt>
                                    <dd><?php echo ucwords($fetch_name['customer_gender']);?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Age</dt>
                                    <dd><?php echo $fetch_name['age'];?></dd>
                                </dl>
                                
                            </div>
                            
                            <div class="pmbb-edit">
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">First Name</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="fname" class="form-control" value="<?php echo ucwords($fetch_name['customer_fname']);?>">
                                        </div>
                                        
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Middle Initial</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="mname" class="form-control" value="<?php echo $fetch_name['customer_mi'];?>">
                                        </div>
                                        
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Last Name</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="lname" class="form-control" value="<?php echo ucwords($fetch_name['customer_lname']);?>">
                                        </div>
                                        
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Gender</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <select class="form-control" name="gender">
                                                <option><?php echo ucwords($fetch_name['customer_gender']);?></option>
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Age</dt>
                                    <dd>
                                        <div class="dtp-container dropdown fg-line">
                                            <input type="text" class="form-control" name="age" value="<?php echo $fetch_name['age'];?>">
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
               
                
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-phone m-r-5"></i> Contact Information</h2>
                            
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
                                    <dt>Mobile Phone</dt>
                                    <dd><?php echo $fetch_name['customer_contact'];?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Address</dt>
                                    <dd><?php echo $fetch_name['customer_addr'];?></dd>
                                </dl>
                              
                            </div>
                            
                            <div class="pmbb-edit">
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Mobile Phone</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="cont" class="form-control" value="<?php echo $fetch_name['customer_contact'];?>">
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Address</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" name="addr" class="form-control" value="<?php echo $fetch_name['customer_addr'];?>">
                                        </div>
                                    </dd>
                                </dl>
                                <div class="m-t-30">
                                    <button type="submit" name="accbtn" class="btn btn-primary btn-sm waves-effect">Save</button>
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
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $mname = $_POST["mname"];
        $gender = mysql_real_escape_string($_POST["gender"]);
        $age = $_POST["age"];

        $update_account = mysql_query("UPDATE customer SET 
                        customer_fname='$fname', customer_lname='$lname',customer_mi='$mname',age='$age' 
                        WHERE customer_num = '" .$_SESSION['user_id']. "'") or die(mysql_error());
?>
         <script type="text/javascript">  
                      $(window).load(function(){
                         swal("Good job!", "You successfully updated your Information!", "success")
                    });

        </script>
<?php
    }
?>   

<?php
    if(isset($_POST["accbtn"]))
    {
        $cont = $_POST["cont"];
        $addr = $_POST["addr"];

        $update_cont = mysql_query("UPDATE customer SET customer_contact = '$cont', customer_addr='$addr'
                        WHERE customer_num='" . $_SESSION['user_id']. "'") or die (mysql_error());  
?>
     <script type="text/javascript">  
                      $(window).load(function(){
                         swal("Good job!", "You successfully updated your Information!", "success")
                    });

        </script>

<?php
    }
?>