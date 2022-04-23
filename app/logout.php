<?php
session_start();
    session_destroy();
    header("Location: http://localhost:9001/login.php");
?>