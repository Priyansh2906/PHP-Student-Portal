<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    if (!isset($_SESSION['logged'])) {
        header('Location:login.php');
    }
    $conn = mysqli_connect("localhost", "root", "", "rbeitest_db");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <title>Solutions</title>
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            background-attachment: fixed;
        }

        span {
            color: #ff8080;
        }
    </style>
</head>

<body>
    <!-- Navbar start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="https://rbeiset.com/"><img src="RBeI.jpg" width="90px" height="40px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <form class="d-flex" action="dashboard.php">
                    <button class="btn btn-transparent" type="submit">Home</button>
                </form>
                <form action="logout.php">
                    <button class="btn btn-transparent" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar ends -->
    <div class="container my-3">
        <?php
        // List of Exams starts
        $uid = $_SESSION['id'];
        $ExmClss = $_SESSION['class'];
        $ExmClss = $ExmClss . '%';
        $sql = "SELECT * FROM `rb_studentexam_tb` WHERE class LIKE '$ExmClss'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        $exam_id_array = array();
        $exam_marks = array();
        $exam_title = array();
        $status_array = array();
        $image = array();
        $testid = $_GET['testid'];

        // ------------------------------------
        // Exam title fetch starts
        while ($TitleRow = mysqli_fetch_array($result)) {
            $titl = $TitleRow[1] . "_" . $TitleRow[0];
            $IdRow = substr($titl, strpos($titl, '_', 0) + 1, strlen($titl));
            array_push($exam_id_array, $IdRow);
            array_push($exam_title, $titl);
        }

        // Exam title fetch ends
        // ------------------------------------
        $status_query = "SELECT * FROM `rb_studentexamresult_tb` WHERE status='incorrect' AND testid=$testid AND studentid=$uid ORDER BY questionid";
        $status_result = mysqli_query($conn, $status_query);
        $status_count = mysqli_num_rows($status_result);

        // image part start
        function second_query($image2, $image3)
        {
            $conn = mysqli_connect("localhost", "root", "", "rbeitest_db");
            $image_query = "SELECT * FROM `rb_studentexamqus_tb` WHERE testid=$image2 AND id=$image3";
            $img_resu = mysqli_query($conn, $image_query) or die(mysqli_error($conn));
            $image_count = mysqli_num_rows($img_resu);
            $image_row = mysqli_fetch_array($img_resu);
            if ($img_resu == TRUE) {
                echo nl2br("<b>Question:</b>\n\n<img src='$image_row[9]' width=75% height=75%>\n\n");
                echo nl2br("<b>Correct Answer : <span style='color:white;text-transform:uppercase'>$image_row[14]</span>\n\n");
                echo nl2br("Solution:\n\n<img src='$image_row[3]' width=75% height=75%>\n\n");
            } else {
                echo ("No Incorrect Answers found!");
            }
        }
        while ($image = mysqli_fetch_array($status_result)) {
            second_query($image[2], $image[3]);
        }
        // image part ends
        ?>
    </div>
</body>

</html>