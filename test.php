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

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- <script language="javascript" type="text/javascript">
        window.history.forward();
    </script> -->
    <title><?php echo ($_SESSION['username']); ?>'s Test Panel</title>
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

    <!-- Table start -->

    <div class="container my-4">
        <table class="table table-striped table-hover table-bordered" id="myTable">
            <thead class="table table-dark">
                <tr style="text-align:center">
                    <th>Test Name</th>
                    <th>Duration</th>
                    <th>Exam Link</th>
                </tr>
            </thead>
            <?php
            $user_id = $_SESSION['id'];
            $ExmClss = $_SESSION['class'];
            $ExmClss = $ExmClss . '%';
            $sql = "SELECT * FROM `rb_studentexam_tb` WHERE class LIKE '$ExmClss'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            while ($TitleRow = mysqli_fetch_array($result)) {
                $titl = $TitleRow[1] . "_" . $TitleRow[0];
                $IdRow = substr($titl, strpos($titl, '_', 0) + 1, strlen($titl));
                echo '<tr class="table-primary" style="text-align:center"><td>' . "$titl" . '</td>';
                echo '<td>' . "$TitleRow[2]" . ' mins</td>';
                echo '<td><button class="btn btn-success"><a href=https://www.rbeiset.com/packageexam/?examid=' . "$IdRow" . '>Start Test</a></button></td></tr>';
            }
            ?>
        </table>
    </div>
    <!-- Datatables javascript start -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <!-- Datatables javascript ends -->
</body>

</html>