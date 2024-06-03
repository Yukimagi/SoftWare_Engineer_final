<?php
include("connection.php");
session_start();
$identity = $_SESSION['identity'];
$name = $_SESSION['name'];
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>用戶詳細資料</title>
    <link href="../css/SAS_CreateMassiveAccount.css" rel="stylesheet" />
    <script src="../js/scripts.js"></script>
</head>
<body>
<div class="content">
    <?php
        echo "<h1>請輸入新建帳號數量</h1>";       // 在這裡顯示用戶詳細資料
        echo '<hr>';
        if (isset($_POST['identity'])) {
            $new_identity = $_POST['identity'];
            echo '<form action="SAS_SQLMassiveCreate.php" method="post">';
            echo '<div class="buttonbox">';
            echo '<input type="number" name="input_number" id="numberbar" required>';
            echo '<br>';
            echo '<hr>';
            echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
            echo '<input type="submit" value="提交" class="leftbutton">';
            echo '<input type="button" value="返回" onclick="location.href=\'SAS_CreateMassiveAccountChoice.php\'" class="rightbutton">';
            echo '</div>';
            echo '</form>';
        } else {
            echo "未提供用戶ID。";
        }
    ?>
</div>
</body>
</html>
