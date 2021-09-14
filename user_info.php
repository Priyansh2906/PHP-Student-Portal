<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>RBeI Users Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="RBeI.jpg" type="image/x-icon">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body style="overflow:scroll">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        $_SESSION['logged'] = 'yes';
        // Creating connection for database
        $conn = mysqli_connect("localhost", "root", "", "rbeitest_db") or die("Connection Failed");
        if (!empty($_POST['login'])) {
            $UserName = $_POST['un'];
            $PassWord = $_POST['pw'];

            if ($UserName == 'Deepak00005' && $PassWord == '8240082894DG') {
                $user_info_query = "SELECT name,class,mobile,email,username,password FROM `rb_user_tb`";
                $user_info_query_result =  mysqli_query($conn, $user_info_query);
                echo '<div class="container my-4">
                <table style="width:75%" class="table table-striped table-hover table-bordered" id="myTable">
                <thead class="table table-dark">
                    <tr style="text-align:center">
                    <th scope="col">Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    </tr>
                </thead>
                <tbody>';
                while ($user = mysqli_fetch_array($user_info_query_result)) {
                    echo "<tr class='table-primary' style='text-align:center'>";
                    echo "<td>$user[0]</td>";
                    echo "<td>$user[1]</td>";
                    echo "<td>$user[2]</td>";
                    echo "<td>$user[3]</td>";
                    echo "<td>$user[4]</td>";
                    echo "<td>$user[5]</td>";
                    echo "</tr>";
                }
                echo '</tbody></table>';
            }
        }
    }
    ?>
    <script>
        $(document).ready(function () {
        $('#myTable').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
    </script>
</body>

</html>