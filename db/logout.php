<?php
session_start();
session_destroy(); // Destrói todas as informações do login
header("Location: index.php");
exit();
?>