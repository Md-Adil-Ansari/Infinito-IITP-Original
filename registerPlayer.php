<?php 
ob_start(); // needs to be added here
?>
<?php
include "connect.php";
include "registerPlayerHandle.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <?php 
    require('./templates/header.php');
    ?>
    <link rel="stylesheet" href="css/registerPlayer.css">
</head>

<body>
    <!--
    =============================================
      Theme Header
    ==============================================
    -->
    <div class="bac" style="background: #172134; position:fixed; width:100%; top:0px; z-index:100; margin-bottom:100px;">
        <div class="container" style="padding:10px 0">
            <a href="index.php" class="logo float-left tran4s"><img src="images/logo/logo.png" alt="Logo" style="border-radius:100%; height:56px; width:56px;" /></a>

            <!-- ========================= Theme Feature Page Menu ======================= -->
            <nav class="navbar float-right theme-main-menu one-page-menu">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        Menu
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1" >
                    <ul class="nav navbar-nav" style="margin-top:8px;">
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./events.php">Events</a></li>
                        <li><a href="./team.php">Team</a></li>
                        <li><a href="./gallery.php">Gallery</a></li>
                        <li class="active"><a href="./registration.php">Register</a></li>
                        <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    echo '<li><a href="./profile.php">Profile</a></li>
                                          <li><a href="./logout.php">Logout</a></li>';
                                }
                                else{
                                    echo '
                                    <li><a href="./signIn.php">Sign In</a></li>';
                                }
                            ?>
                    </ul>
                </div>
              <!-- /.navbar-collapse -->
            </nav>
            <!-- /.theme-feature-menu -->
        </div>
    </div>

        
    <!-- /.theme-main-header -->
    <div class="container">

        <div id="register" style="padding:5%;padding-top:75px;">
            <div class="theme-title" style="margin-bottom:40px;margin-top:80px;">
                <h2 style="margin-top:0px;">Register</h2>
            </div>

            <div class="signInForm reg_PlayerForm">
            <form method="post" action="">
                <div class="form-group row regPlayerForm">
                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-new" id="name" name="name" placeholder="Name *"  required>
                    </div>
                </div>

                <div class="form-group row regPlayerForm" >
                    <label for="clg" class="col-sm-4 col-form-label">College</label>
                    
                    <div class="col-sm-9">
                        <input type="radio" id="clg1" name="clg" value="other" onclick="displayName()">
                        <label for="clg1">Other</label><br>
                        <input type="radio" id="clg2" name="clg" value="Indian Institute of Technology Patna" onclick="displayId()">
                        <label for="clg2">Indian Institute of Technology Patna</label><br>  
                    </div>
                </div>

                <div class="form-group row regPlayerForm" >
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control-new" id="email" name="email" placeholder="Enter Email *" required>
                        <div id="emailError"></div>
                    </div>
                </div>

                
                <div id="displayMidSignUp">

                </div>
                <div class="form-group row regPlayerForm"  >
                    <label for="phone" class="col-sm-4 col-form-label">Phone Number</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control-new" id="phone" name="phone_no" maxlength="10" placeholder="Enter Phone Number *" required>
                    </div>
                </div>
                <div class="form-group row regPlayerForm" >
                    <label for="gender" class="col-sm-4 col-form-label">Gender</label>
                    <div class="col-sm-9">
                        <select name="gen" class="selectForm" id="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="RNS">Rather Not Say</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row regPlayerForm" >
                    <label for="create_pass" class="col-sm-4 col-form-label">Create Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control-new" id="create_pass" name="create_password" placeholder="Create Password *" required>
                    </div>
                </div>
                <div class="form-group row regPlayerForm" >
                    <label for="confirm_pass" class="col-sm-4 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control-new" id="confirm_pass" name="confirm_password" placeholder="Enter Password Again *" required>
                        <div id="passError"></div>
                        <div style="margin-top:2px;">
                            <input type="checkbox" name="showPass" id="showPass" onclick="showPassword()">
                            <label for="showPass">Show Password</label><br>  
                        </div>
                    </div>
                </div>
                
                <div class="form-group row regPlayerForm" >
                    <div class="col-sm-9 regPlayerSubmit">
                        <button type="button" class="btn btn-primary" name="indiReg" onclick="checkPassword()" id="indiReg" >Register</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
 
    <div style="width:100%;display:flex;align-items:center;flex-direction:column; font-size:1.4rem; margin-top:20px;">
        <p>For any queries contact us at <a href="mailto:iitpsports@gmail.com" target="_blank">iitpsports@gmail.com</a>
    </div>
    
    <?php
    require('./templates/footer.php')
    ?>

    <script>
        
        function displayName(){
            displayString = '<div class="form-group row regPlayerForm"><label for="oth_clg_name" class="col-sm-4 col-form-label">College Name (Full)</label><div class="col-sm-9"><input type="text" class="form-control-new" id="oth_clg_name" name="oth_clg_name" placeholder="Enter College Name*" required></div></div>';
            displayString += '<div class="form-group row regPlayerForm" ><label for="clgid" class="col-sm-4 col-form-label">College ID / Roll no.</label><div class="col-sm-9"><input type="text" class="form-control-new" id="clgid" name="clgid" placeholder="College ID *" required></div></div>';
            document.getElementById("displayMidSignUp").innerHTML = displayString;
            document.getElementById("email").placeholder = "Enter Email *";
            if(document.getElementById("email").style.color == "red"){
                document.getElementById("email").style.color = "black";
                document.getElementById("emailError").innerHTML = '';
            }
        }
        function displayId(){
            displayString = '<div class="form-group row regPlayerForm" ><label for="clgid" class="col-sm-4 col-form-label">College ID / Roll no.</label><div class="col-sm-9"><input type="text" class="form-control-new" id="clgid" name="clgid" placeholder="College ID*" required></div></div>';
            document.getElementById("displayMidSignUp").innerHTML = displayString;
            document.getElementById("email").placeholder = "Enter IITP Webmail *";
        }

        function checkPassword(){
            if(document.getElementById("create_pass").value == document.getElementById("confirm_pass").value){
                document.getElementById("passError").innerHTML = '';
                document.getElementById("confirm_pass").style.color = "black";
                if(document.getElementById("clg2").checked){
                    var iitpMail = document.getElementById("email").value;
                    if(iitpMail.substr(iitpMail.indexOf("@")+1) == "iitp.ac.in"){
                        var indiRegBtn = document.getElementById("indiReg");
                        indiRegBtn.setAttribute('type', 'submit');
                    }
                    else{
                        document.getElementById("email").style.color = "red";
                        document.getElementById("emailError").innerHTML = '<p style="color:red;">Enter IITP Webmail !<p>';
                    }
                }
                else{
                    var indiRegBtn = document.getElementById("indiReg");
                    indiRegBtn.setAttribute('type', 'submit');
                }
            }
            else{
                document.getElementById("confirm_pass").style.color = "red";
                document.getElementById("passError").innerHTML = '<p style="color:red;">Passwords do not match !<p>';
                if(document.getElementById("clg2").checked){
                    var iitpMail = document.getElementById("email").value;
                    if(iitpMail.substr(iitpMail.indexOf("@")+1) == "iitp.ac.in"){
                        document.getElementById("email").style.color = "black";
                        document.getElementById("emailError").innerHTML = '';
                    }
                    else{
                        document.getElementById("email").style.color = "red";
                        document.getElementById("emailError").innerHTML = '<p style="color:red;">Enter IITP Webmail !<p>';
                    }
                }
            }     
        }

        function showPassword(){
            if(document.getElementById("showPass").checked == true){
                document.getElementById("create_pass").setAttribute('type','text');
                document.getElementById("confirm_pass").setAttribute('type','text');            
            }
            else{
                document.getElementById("create_pass").setAttribute('type','password');
                document.getElementById("confirm_pass").setAttribute('type','password');
            }
        }        
    </script>
</body>
</html>