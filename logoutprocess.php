<script src="js/scripts.js"></script>
<?php
session_start();
$_SESSION = array();
session_destroy();
echo '<script>logoutmsg()</script>';
?>