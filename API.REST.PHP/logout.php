<?php
session_start();
session_destroy(); // destroy session
header("Location: index.php"); // Redirect  login
exit();
?>