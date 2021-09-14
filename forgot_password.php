<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $conn = mysqli_connect("localhost", "root", "", "rbeitest_db");
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>RBeI Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
</head>
<div class="center">
    <h1>Forgot Password</h1>
    <form method="post" action=''>
        <div class="txt_field">
            <input type="text" name="email" onkeypress="return (event.charCode > 63 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32) || (event.charCode>45 && event.charCode<58)" required>
            <span></span>
            <label>Enter Registered Email</label>
        </div>
        <div class="txt_field">
            <input type="tel" name="mobile_number" maxlength="10" onkeypress="return (event.charCode > 47 && event.charCode < 58)" required>
            <span></span>
            <label>Enter Registered Mobile</label>
        </div>
        <br><input type="submit" name="forgot" value="Submit">
        <div class="container-fluid">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $conn = mysqli_connect("localhost", "root", "", "rbeitest_db");
                $submitted_email = $_POST['email'];
                $submitted_mobile = $_POST['mobile_number'];
                $select_credentials = "SELECT name,username,password FROM `rb_user_tb` WHERE email='$submitted_email' AND mobile='$submitted_mobile'";
                $select_credentials_result = mysqli_query($conn, $select_credentials);
                $count = mysqli_num_rows($select_credentials_result);
                echo $count;
                if ($count == 1) {
                    while ($credentials = mysqli_fetch_array($select_credentials_result)) {
                        $full_name = $credentials[0];
                        $username = $credentials[1];
                        $password = $credentials[2];
                    }
                    $send_to = $submitted_email;
                    $mobile = $submitted_mobile;
                    $subject = "RBEI Account Information";
                    $message = "<html>
                        <head>
                        <title>Rajbala Educational Institution PVT LTD</title>
                        </head>
                        <body>
                        <center><img src='http://dev.rbeiset.com/logo.jpg' style='width:100%'></center>
                        <h4>Hi " . $full_name . "</h4>
                        <h4>You have initiated a forgot password action on your account on RBEI portal.</h4>
                        <h4>Your Account Credentials</h4>
                        <h4>Username: " . $mobile . "</h4>
                        <h4>Password: " . $password . "</h4>
                        <h4>Please Contact Desk Office if this action wasn't performed by you</h4>
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

                    mail($send_to, $subject, $message, $headers);
                    echo '<br>';
                    echo '<div class="container-fluid alert alert-success alert-dismissible fade show" role="alert">
                    <center><strong>An email with username and password details has been sent to the submitted email!</strong></center>
                    </div>';
                }
            }
            ?>
        </div>
        <br>
    </form>
</div>

<body>

</body>

</html>