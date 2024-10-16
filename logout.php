<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
</head>
<body>
    <p>You have been logged out. <a href="login.php">Login again</a></p>
</body>
</html>
