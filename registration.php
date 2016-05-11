<?php require_once('header.php'); ?>
<div class="container">
    <div class="block-header">
        <h2>Personal Information</h2>
    </div>
	
	<form method="post" id="personalinfo" action="registration.php">
        <div class="card">
            <div class="card-body card-padding">
                <br><br>
                <div class="row">
                    <div class="col-sm-6">         
                    	<div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-assignment-account"></i></span>
                            <div class="fg-line">
                                <input type="text" name="lastname" id="lastname" placeholder="Last Name" class="form-control">
                                
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-assignment-account"></i></span>
                            <div class="fg-line">
                                <input type="text" name="firstname" id="firstname" placeholder="First Name" class="form-control">
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-assignment-account"></i></span>
                            <div class="fg-line">    
                                <input type="text" name="mi" id="mi" placeholder="Middle Initial" class="form-control" maxlength="1">
                            </div>
                        </div>
                        
                        <br>

                        <div class="input-group">
                            <span class="input-group-addon last"><i class="zmdi zmdi-male-female"></i></span>
                            <div class="fg-line">
                                <select class="selectpicker bs-select-hidden" name="gender" id="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <br>

                    <div class="col-sm-6">                       
                        <div class="input-group">
                            <span class="input-group-addon last"><i class="zmdi zmdi-hourglass-alt"></i></span>
                            <div class="fg-line">
                                <input type="text" name="age" placeholder="age" id="age" class="form-control">
                               
                            </div>
                        </div>
                        
                        <br>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-nature-people"></i></span>
                            <div class="fg-line">
                                <input type="text" name="address" placeholder="Address" id="address" class="form-control">
                            </div>
                        </div>
                        
                        <br>

                        <div class="input-group fg-float">
                            <span class="input-group-addon last"><i class="zmdi zmdi-account-box-phone"></i></span>
                            <div class="fg-line">
                                <input type="text" name="contactno" id="contactno" class="form-control input-mask" data-mask="000 0000 0000">
                                <label class="fg-label">Mobile: e.g. 093 2123 4567</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
        	</div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>User Account</h2>
            </div>
            
            <div class="card-body card-padding">
                <br><br>
                <div class="row">
                    <div class="col-sm-4">                       
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                            <div class="fg-line">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-sm-4">                       
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-lock-outline"></i></span>
                            <div class="fg-line">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-sm-4">                       
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            <div class="fg-line">
                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
            			<button type="submit" name="submitbtn" class="btn btn-primary waves-effect">Submit</button>
            		</div>
            	</div>
            </div>
        </div>
    </form>
</div>
<?php require_once('footer.php'); ?>
<?php
    if(isset($_POST["submitbtn"]))
    {
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $mi = $_POST["mi"];
        $gender = mysql_real_escape_string($_POST["gender"]);
        $age = $_POST["age"];
        $addr = $_POST["age"];
        $contno = $_POST["contactno"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpword = $_POST["cpassword"];

        $select_uname = mysql_query("SELECT * FROM useraccount WHERE uname = '$username'");
        $numrows = mysql_num_rows($select_uname);

        if($cpword != $password)
        {
    ?>

            <script type="text/javascript">  
                      $(window).load(function(){
                        swal("Password Missmatch")
                    });
            </script>
<?php
        }
            elseif($numrows >= 1)
            {
?>
            <script type="text/javascript">  
                      $(window).load(function(){
                        swal("Username Already exist")
                    });
            </script> 
<?php
        }
        else
        {
            $selectnumber = mysql_query("SELECT customer_num FROM customer ORDER BY 1 DESC");
            $number = mysql_fetch_assoc($selectnumber);

                $customernumber =$number["customer_num"];

            $insertinfo = mysql_query("INSERT INTO `customer`(`customer_num`, `customer_lname`, `customer_fname`, `customer_mi`, `customer_gender`, `age`, `customer_addr`, `customer_contact`, `customer_datereg`, `customer_status`) 
                                                VALUES('$customernumber'+1,'$lastname','$firstname','$mi','$gender','$age','$addr','$contno',now(),'')") or die(mysql_error());
            $insert_acc = mysql_query("INSERT INTO `useraccount`(`user_id`, `uname`, `pword`, `usertype`) 
                                    VALUES('$customernumber'+1,'$username','$password','Customer')");    
?>
        <script type="text/javascript">  
                      $(window).load(function(){
                         swal("Good job!", "Successfully Registered!", "success")

                         window.location="login.php";
                    });
        </script>
<?php  
        }          
    }
?>
