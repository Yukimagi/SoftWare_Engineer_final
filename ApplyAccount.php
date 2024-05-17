<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>帳號申請</title>
    <link href="css/SAS_CreateAccount.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
</head>
<body>
<div class="content">
    <?php
        include("connection.php");

        $sql_query = "SELECT MAX(account_applications.id) as now FROM account_applications";
        $result = $conn->query($sql_query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $currentid = $row['now'];
        $numberPart = (int)substr($currentid, 2); // 提取數字部分，並轉換為整數
        $newNumberPart = $numberPart + 1; // 增加 1
        $new_id = "ap" . str_pad($newNumberPart, 5, "0", STR_PAD_LEFT); // 補齊零填充並連接回 "ap" 字母
        
        echo "<h1>請填寫帳號申請表</h1>";       // 在這裡顯示用戶詳細資料
        echo '<hr>';

        echo '<div class="profile_form">';
        echo '<form action="applyprocess.php" method="post">';
        echo '<table class="profile_table">';
        echo '<tr>';
            echo '<th></th>';
            echo '<th></th>';
            echo '<th></th>';
            echo '<th></th>';
        echo '</tr>';
        echo '<tr>';
            echo '<td><label for="name">姓名</label></td><td><input type="text" name="name"></td>';
            echo '<td><label for="phone">連絡電話</label></td><td><input type="text" name="phone"></td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td><label for="reason">個人簡介/自己PR</label></td><td><textarea name="reason" rows="10" cols="60" required></textarea></td>';
        echo '</tr>';
        echo '</table>';
        echo '<br>';
        echo '<hr>';
        echo '<div class="buttonbox">';
        echo '<input type="hidden" name="id" value="' . $new_id . '">';
        echo '<input type="submit" value="儲存" class="leftbutton">';
        echo '<input type="button" value="返回" onclick="" class="rightbutton">';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    ?>
</div>
</body>
</html>