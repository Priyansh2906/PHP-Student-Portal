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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- <script language="javascript" type="text/javascript">
        window.history.forward();
    </script> -->
    <title><?php echo ($_SESSION['username']); ?> Progress Report</title>
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
    <!-- Table start -->
    <div class="container my-4">
        <table class="table table-striped table-hover table-bordered" id="myTable">
            <thead class="table-dark">
                <tr style="text-align:center">
                    <th scope="col">Serial No.</th>
                    <th scope="col">List of Test</th>
                    <th scope="col">Exam Status</th>
                    <th scope="col">Score</th>
                    <th scope="col">View Wrong Answers</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // List of Exams starts
                $uid = $_SESSION['id'];
                $ExmClss = $_SESSION['class'];
                $ExmClss = $ExmClss . '%';
                $sql = "SELECT * FROM `rb_studentexam_tb` WHERE class LIKE '$ExmClss'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                $exam_serial_array = array();
                $exam_id_array = array();
                $exam_marks = array();
                $exam_title = array();

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
                foreach ($exam_id_array as $value) {
                    $user_id = $_SESSION['id'];
                    $marks_query = "SELECT * FROM `rb_studentexamresult_tb` WHERE studentid='$user_id' AND testid='$value'";
                    $result1 = mysqli_query($conn, $marks_query);
                    $count1 = mysqli_num_rows($result1);
                    $total_marks = 0;
                    while ($row = mysqli_fetch_array($result1)) {
                        $total_marks += $row[6];
                    }
                    $percent_marks = ($total_marks * 100) / 80;
                    array_push($exam_marks, $percent_marks);
                }

                for ($i = 0; $i < count($exam_id_array); $i++) {
                    $i = $i + 1;
                    array_push($exam_serial_array, $i);
                    echo "<tr class='table-success' style='text-align:center'><td>$i</td>";
                    $i = $i - 1;
                    echo "<td>$exam_title[$i]</td>";
                    if ($exam_marks[$i] > 0) {
                        echo "<td>Given</td>";
                    } else {
                        echo "<td> Exam Pending </td>";
                    }
                    echo "<td>$exam_marks[$i]%</td>";
                    if ($exam_marks[$i] > 0) {
                        echo "<td><a href='solution.php?testid=$exam_id_array[$i]'><input type='button' class='btn btn-success' id='butn' value='View Solution'></a></td></tr>";
                    } else {
                        echo "<td><button class='btn btn-success disabled'>Exam Pending</button></td></tr>";
                    }
                }
                ?>
                <!-- Score ends -->
                <!-- <script>
                    $(document).ready(function() {
                        $('input[id="butn"]').attr('disabled', true);
                        if ($(this).val == true) {
                            $('input[id="butn"]').attr('disabled', false);
                            document.getElementById("butn").style.color = "green";
                            document.getElementById("butn").value = "View Solution";
                        } else {
                            $('input[id="butn"]').attr('disabled', true);
                            document.getElementById("butn").style.color = "red";
                            document.getElementById("butn").value = "Exam Pending";
                        }
                    });
                </script> -->
            </tbody>
        </table>
        <!-- Table ends -->
        <center>
            <input type="button" class="btn btn-success" id="view_chart_btn" value="View Detailed Marks Graph">
            <div id="columnchart_material" style="width: 800px; height:500px; display:none;"></div>
        </center>
    </div>
    <!-- Datatables javascript start -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <!-- Datatables javascript ends -->

    <!-- Graph Starts -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(initialize);

        function initialize() {
            $("#view_chart_btn").click(function() {
                document.getElementById("view_chart_btn").style.display = "none";
                document.getElementById("columnchart_material").style.display = "block";
                drawChart();
                document.getElementById("columnchart_material").scrollIntoView();
            });
        }
        var serial = JSON.parse('<?php echo json_encode($exam_serial_array); ?>');
        var Marks = JSON.parse('<?php echo json_encode($exam_marks); ?>');
        console.log(serial);
        console.log(Marks);

        function drawChart() {
            // create Datatable
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Exam Subject Serial.');
            data.addColumn('number', 'Marks');
            console.log("Data is : ");
            console.log(data);
            // load data
            for (var i = 0; i < Marks.length; i++) {
                var row = [serial[i], Marks[i]];
                data.addRow(row);
            }
            var options = {
                chart: {

                }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <!-- Graph Ends -->
</body>

</html>