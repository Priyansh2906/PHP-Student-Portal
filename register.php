<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "rbeitest_db");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>RBeI Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
</head>

<body>
    <div class="center">
        <h1>Register</h1>
        <form method="post" action=''>
            <div class="txt_field">
                <input type="text" name="name" maxlength="40" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32) || (event.charCode>47 && event.charCode<58)" required>
                <span></span>
                <label>Enter Your Name</label>
            </div>
            <div class="txt_field">
                <input type="text" name="email" onkeypress="return (event.charCode > 63 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32) || (event.charCode>45 && event.charCode<58)" required>
                <span></span>
                <label>Enter Your Email</label>
            </div>
            <div class="txt_field">
                <input type="tel" name="mobile_number" maxlength="10" onkeypress="return (event.charCode > 47 && event.charCode < 58)" required>
                <span></span>
                <label>Enter Your Mobile No.</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" maxlength="10" onkeypress="return (event.charCode > 47 && event.charCode < 58)" required>
                <span></span>
                <label>Create Password(Numbers Only)</label>
            </div>
            <div class="dropdown">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "rbeitest_db") or die("Connection Failed");
                $register_select_class_query = "SELECT * FROM `rb_class_tb`";
                $register_select_class_result = mysqli_query($conn, $register_select_class_query) or die(mysqli_error($conn));
                echo "<form method='GET'>
                <label>Select Your Class: </label>
                <select name='register_class' id='register_class'>";
                while ($register_select_class_row = mysqli_fetch_array($register_select_class_result)) {
                    echo "<option value='$register_select_class_row[1]'>$register_select_class_row[1]</option>";
                }
                echo "</select></form><br>";
                ?>
                <br><input type="submit" name="signup" value="SignUp">
            </div>
            <div class="signup_link">
                <p>Already Have An Account?<a href="Login.php"> Login</p>
            </div>
            <div class="container-fluid">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Creating connection for database

                    $full = $_POST['name'];
                    $email = $_POST['email'];
                    $mobile = $_POST['mobile_number'];
                    $password = $_POST['password'];
                    $class_name = $_POST['register_class'];

                    $check_mobile_number_query = "SELECT mobile FROM `rb_user_tb` WHERE mobile=$mobile";
                    $check_mobile_number_result = mysqli_query($conn, $check_mobile_number_query) or die(mysqli_error($conn));
                    $check_mobile_number_count = mysqli_num_rows($check_mobile_number_result);
                    // $check_mobile_number_row=mysqli_fetch_array($check_mobile_number_result);
                    if ($check_mobile_number_count == 0) {
                        $insert_info_db_query = "INSERT INTO rb_user_tb(name,class,mobile,email,username,password) values('$full','$class_name','$mobile','$email','$mobile','$password')";
                        $insert_info_db_query_execute = mysqli_query($conn, $insert_info_db_query) or die(mysqli_error($conn));
                        echo '<div class="container-fluid alert alert-success alert-dismissible fade show" role="alert">
                        <center><strong>You are Registered Successfully!</strong></center>
                        </div>';
                        sleep(2);

                        //Sending Email
                        $send_to = $email;
                        $subject = "Account Registred on RBEI Portal";
                        $message = "<html>
                        <head>
                        <title>Rajbala Educational Institution PVT LTD</title>
                        </head>
                        <body>
                        <center><img src='http://dev.rbeiset.com/logo.jpg' style='width:100%'></center>
                        <h4>Hi ".$full."</h4>
                        <h4>Your Account has been successfully registred on RBEI Portal.</h4>
                        <h4>Your Account Credentials</h4>
                        <h4>Username: ".$mobile."</h4>
                        <h4>Password: ".$password."</h4>
                        <h4>Please Contact Desk Office if any further queries</h4>
                        <h4>Thank You</h4>
                        <h4>RBEI Team</h4>
                        <h4>rbeiset.com</h4>
                        <h4>contact.rbei@gmail.com</h4>
                        <h4>8583905853</h4>
                        </body>
                        </html>";

                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                        // More headers
                        $headers .= 'From: <mailer@rbeiset.com>' . "\r\n";
                        $headers .= 'Cc: noreply@rbeiset.com' . "\r\n";

                        mail($send_to,$subject,$message,$headers);
                        
                    } else {
                        echo '<div class="container-fluid alert alert-danger alert-dismissible fade show" role="alert">
                        <center><strong>You are Already Registered!</strong></center>
                        </div>';
                    }
                }
                ?>
            </div>
        </form>
    </div>
</body>

</html>