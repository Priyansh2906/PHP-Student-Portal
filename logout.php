<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["id"]);
unset($_SESSION["class"]);
session_destroy();
session_write_close();
header('Location: /internship/login.php');
exit();
?>
<!DOCTYPE html>
<html lang="en">

<body>

</body>

</html>