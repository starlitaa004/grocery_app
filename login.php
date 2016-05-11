<?php require_once('header.php'); ?>
<center>
    <form method="post">
        <div class="lc-block toggled" id="l-login">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <button type="submit" name="login" style="padding:0px;" class="btn btn-login btn-danger btn-float waves-effect waves-circle waves-float">
              LOGIN
            </button>

            <ul class="login-navigation">
                <li><a href="registration.php" class="btn bgm-teal btn-lg waves-effect">Register</a></li>
                <!-- <li><a href="#" class="btn bgm-deeporange btn-xs waves-effect">Forgot Password</a></li> -->
            </ul>
        </div>
    </form>
</center>
<?php require_once('footer.php'); ?>
<?php
    if(isset($_POST['login'])) {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username   = $_POST['username'];
            $password   = $_POST['password'];

            $query = mysql_query("SELECT * FROM useraccount WHERE uname = '". $username ."' AND pword = '". $password ."'");
            $numrows = mysql_num_rows($query);

            if($numrows != 0) {
                $row = mysql_fetch_assoc($query);
                $_SESSION['user_id']  = $row['user_id'];
                $_SESSION['username'] = $row['uname'];
                
                if(isset($_SESSION['storeid']) && isset($_SESSION['limit']) && isset($_SESSION['category'])) {
                    echo "<script language='javascript'>window.location = ['cart.php?storeid=". $_SESSION['storeid'] ."&limit=". $_SESSION['limit'] ."&category=". $_SESSION['category'] ."']</script>";
                } else {
                    echo "<script language='javascript'>window.location = ['index.php']</script>";
                }
            } else {
                echo "Invalid Username or Password";
            }
        } else {
            echo "No Username or Password provided";
        }
    }
?>