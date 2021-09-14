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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- <script language="javascript" type="text/javascript">
        window.history.forward();
    </script> -->
    <title>Important LOS</title>
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            background-attachment: fixed;
        }

        a {
            color: #ffcc99;
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

    <!-- Dropdown Starts -->
    <?php
    $course_class = $_SESSION['class'];
    $course_class = $course_class . '%';
    $sub_query = "SELECT DISTINCT subject_name FROM `rb_subject_tb` WHERE class LIKE '$course_class'";
    $sub_result = mysqli_query($conn, $sub_query) or die(mysqli_error($conn));
    $sub_count = mysqli_num_rows($sub_result);
    if (!isset($_SESSION['class'])) {
    }

    if ($sub_count == 0) {
        echo "<center>
        <div class='container my-4'>No Data Found for this Student!</div>
        </center>";
    } else {
        echo "<div class='container my-4'>
        <form action='los.php' method='GET'>
        <label>Select Subject: </label>
        <select class='dropdown' id='class_dropdown' name='class_dropdown' style='width: 22%;'>";
        while ($sub_row = mysqli_fetch_array($sub_result)) {
            echo "<option value='$sub_row[0]'>" . $sub_row[0] . "</option>";
        }
        echo "</select> &nbsp &nbsp &nbsp
        <input class='btn btn-danger' type='submit' name='subject_select' id='subject_select' value='Proceed'>
        </form>
        </div>";
    }
    ?>
    <!-- Dropdown Ends -->
    <script>
        function proceedBtnClick() {
            document.getElementById('class_dropdown').value = "<?php echo $_GET['class_dropdown']; ?>";
        }
    </script>

    <!--GET REQUEST Start-->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['subject_select'])) {
            $course_class = $_SESSION['class'];
            // echo $course_class;
            // exit();
            $selected_subject = $_GET['class_dropdown'];
            $chapter_select_query = "SELECT Chapter FROM `imp_ch_los` WHERE subject='$selected_subject' AND Class='$course_class'";
            $chapter_select_result = mysqli_query($conn, $chapter_select_query) or die(mysqli_error($conn));

            while ($chapter_select_row = mysqli_fetch_array($chapter_select_result)) {
                echo '<div class="container my-4">
                <table style="width:75%" class="table table-striped table-hover table-bordered"
                <thead class="table table-dark">
                    <tr class="table-dark" style="text-align:center">
                    <th scope="col" colspan=4>' . "$chapter_select_row[0]" . '</th>
                    </tr>
                    <tr class="table-primary" style="text-align:center">
                    <th scope="col">IMP Topic</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Nature</th>
                    <th scope="col">Importance</th>
                    </tr>
                </thead>
                <tbody>';

                $select_chapter_imp_data = "SELECT * FROM `imp_ch_los` WHERE Subject='$selected_subject' AND Chapter='$chapter_select_row[0]'";
                $select_chapter_imp_data_result = mysqli_query($conn, $select_chapter_imp_data) or die(mysqli_error($conn));
                while ($select_chapter_imp_data_row = mysqli_fetch_array($select_chapter_imp_data_result)) {
                    echo '<tr class="table-danger" style="text-align:center">
                            <td>' . "$select_chapter_imp_data_row[4]" . '</td>
                            <td>' . "$select_chapter_imp_data_row[5]" . '</td>
                            <td>' . "$select_chapter_imp_data_row[6]" . '</td>
                            <td>' . "$select_chapter_imp_data_row[7]" . '</td>
                        </tr>';
                }
                echo '</tbody></table>';
            }
        }
        echo '<script type="text/javascript">proceedBtnClick();</script>';
    }
    ?>
    <!--GET REQUEST Ends-->
</body>

</html>