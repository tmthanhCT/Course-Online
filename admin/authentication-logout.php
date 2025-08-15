<?php
session_start();
session_unset();
session_destroy();
header("Location: studyhub/index.php");
exit();
?>