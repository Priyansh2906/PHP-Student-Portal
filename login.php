<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <title>RBeI Log-in</title>
  <script language="javascript" type="text/javascript">
    window.history.forward();
  </script>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="RBeI.jpg" type="image/x-icon">
</head>

<body>
  <div class="center">
    <h1>Login</h1>
    <form method="post">
      <div class="txt_field">
        <input type="text" name="un" maxlength="20" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32) || (event.charCode>47 && event.charCode<58)" required>
        <span></span>
        <label>Username</label>
      </div>
      <div class="txt_field">
        <input type="password" name="pw" maxlength="10" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32) || (event.charCode>47 && event.charCode<58)" required>
        <span></span>
        <label>Password</label>
      </div>
      <input type="submit" name="login" value="Login">
      <div class="signup_link">
        <p>Don't Have Account?<a href="register.php"> Sign Up</a></p>
        <p><a href="forgot_password.php"> Forgot Password?</a></p>
      </div>
      <div class="container-fluid">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          session_start();
          $_SESSION['logged'] = 'yes';
          // Creating connection for database
          $conn = mysqli_connect("localhost", "root", "", "rbeitest_db") or die("Connection Failed");

          if (!empty($_POST['login'])) {
            $UserN = $_POST['un'];
            $PassW = $_POST['pw'];
            $query = "SELECT * FROM `rb_user_tb` WHERE username='$UserN' AND password='$PassW'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);
            if ($count == 1) {
              $TmpClss = $row['class'];
              $_SESSION['username'] = $UserN;
              $_SESSION['class'] = $TmpClss;
              $user_id = $row[0];
              $_SESSION['id'] = $user_id;
              header("Location:dashboard.php");
            } else {
              echo '<div class="container-fluid alert alert-danger alert-dismissible fade show" role="alert">
              <center><strong>Log-In Unsuccessfull! Please Enter Valid username or password </strong></center>
              </div>';
              echo '<div class="container-fluid"><br></div>';
            }
          }
        }
        ?>
      </div>
    </form>
  </div>
</body>

</html>