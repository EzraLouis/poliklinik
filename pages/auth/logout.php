<?php
include_once("../../config/conn.php");
session_start();
// destroy all session variables
session_unset();

// destroy the session itself
session_destroy();

// redirect to login page
header('Location: /BK_Poliklinik/');
exit;
?>
