<?php
    if (!isset($_SESSION)) { session_start(); }
    $_SESSION = array(); 
    session_destroy(); 
    header("Location: http://127.0.0.1:8000/");
    exit();
?>
