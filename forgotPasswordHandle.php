<?php
include 'connect.php';
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
    header('location:profile.php');
    end();
}
$unique = "false";
if(isset($_POST["otp"])){
    $infid = $_POST['infid'];

    $sql = "SELECT * FROM `participant`";
    $result = mysqli_query($conn, $sql);
    while($check = mysqli_fetch_assoc($result)){
            //$cur_infid -> email of current row
            $cur_infid = $check['InfId'];
            //checking
            if($infid == $cur_infid)
            {
                $unique = "true";
                break;
            }
        }
    if($unique=="false"){
        //if Infinito ID does not exist then display a message
        echo '<div class="alert alert-success alert-dismissible show" role="alert" style="position:absolute; top:75px; width:100%; color:red; background: #ff000020;" >
        <strong> No such Infinito ID found.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">x</span>
        </button>
        </div>';
    }
    else{
        //sending otp if infinito id is correct
        $sql = "SELECT * FROM `participant` WHERE `InfId`='$infid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $to = $row['Email'];
        $name = $row['Name'];
        $subject = "OTP (Forgot Password)";
        $otp = rand(100000,999999);
        $message = "Your OTP is <strong>".$otp."</strong><br>";
        require 'mail.php';
        if($mail->send()){
            session_start();
            $_SESSION['otp']= $otp;
            $_SESSION['infid'] = $infid;
            $_SESSION['forgot'] = "active";
            header('location:validateOTP.php');
        }
        else{
            echo '<div class="alert alert-success alert-dismissible show" role="alert" style="position:absolute; top:75px; width:100%; color:red; background: #ff000020;" >
            <strong>Sorry OTP could not be send due to technical errors. Please enter Infinito ID again.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">x</span>
            </button>
            </div>';
        }
    }
    
}

