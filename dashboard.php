<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location:login.php');
}
$conn = mysqli_connect("localhost", "root", "", "rbeitest_db") or die("Connection Failed");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard.css">
    <title><?php echo ($_SESSION['username']); ?>'s DashBoard</title>
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
    <!-- <script language="javascript" type="text/javascript">
        window.history.forward();
    </script> -->
</head>

<body background="Material.jpg">
    <input type="checkbox" id="check">
    <!-- Header Area start -->
    <header>
        <label for="check">
            <i class="fas fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <a href="https://rbeiset.com/"><img src="RBeI.jpg" width="70px" height="40px"></a>
        </div>
    </header>
    <!-- Header Area ends -->

    <!-- Sidebar start -->
    <div class="sidebar">
        <center>
            <i class="bi bi-person-circle"></i>
            <h4><?php echo ($_SESSION['username']); ?></h4>
            <?php
            if (!isset($_SESSION['username'])) {
            }
            // else{
            // header('Location: login.php');
            // }
            ?>
        </center>
        <a href="report.php"><i class="fas fa-tasks"></i><span>Progress Report</span></a>
        <a href="about.php"><i class="fas fa-info-circle"></i><span>About You</span></a>
        <a href="https://studde.com/"><i class="fas fa-video"></i><span>Lectures</span></a>
        <a href="test.php"><i class="fas fa-graduation-cap"></i><span>Test Panel</span></a>
        <a href="courses.php"><i class="fas fa-university"></i><span>Courses</span></a>
        <a href="los.php"><i class="far fa-star"></i><span>Imp LOS</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </div>
    <!-- Sidebar ends -->

    <div class="content"></div>
</body>

</html>