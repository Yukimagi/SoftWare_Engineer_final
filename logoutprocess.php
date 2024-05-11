<script src="js/scripts.js"></script>
<?php
session_start(); // 啟動 session
$_SESSION['logged_in'] = 'false';
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 'false') {
     // 清除所有的 session 資料
    session_unset();
    // 銷毀 session
    session_destroy();
    // 重新導向到登入頁面或其他適合的頁面
    echo '<script>logoutmsg()</script>';
    exit;
}
?>