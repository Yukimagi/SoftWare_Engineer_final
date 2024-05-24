<?php
session_start();
$identity = $_SESSION['identity'];
$name = $_SESSION['name'];
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="../css/SAS_UserDetails.css" rel="stylesheet" />
    <script src="../js/scripts.js"></script>
</head>
<body>
<div class="content">
    <?php
        include("connection.php");
        
        // 檢查是否有傳遞用戶ID
        if (isset($_POST['apply_id'])) {
            $apply_id = $_POST['apply_id'];

            $sql_query = "select * from account_applications where id='" . $apply_id . "'";
            $result = $conn->query($sql_query);
            if ($result->rowCount() > 0) {
                $user_profile = $result->fetch(PDO::FETCH_ASSOC);
                $user_profile_array = array_values($user_profile);
                echo "<h1>帳號資料修改</h1>";// 在這裡顯示用戶詳細資料
                echo "<hr>";

                echo '<div class="profile_form">';
                echo '<form action="SAS_SQLUpdate.php" method="post" onsubmit="return updateconfirm()">';
                echo '<table class="profile_table">';
                echo '<tr>';
                    echo '<th></th>';
                    echo '<th></th>';
                    echo '<th></th>';
                    echo '<th></th>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td><label for="landlord_name">申請者姓名</label></td><td><input type="text" name="landlord_name" value="' . $user_profile_array[1] . '" readonly="true"></td>';
                    echo '<td><label for="landlord_phone">申請者連絡電話</label></td><td><input type="text" name="landlord_phone" value="' . $user_profile_array[2] . '"></td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td><label for="landlord_line">申請理由</label></td><td><input type="text" name="landlord_line" value="' . $user_profile_array[4] . '"></td>';
                echo '</tr>';
                echo '</table>';
                echo '<br>';
                echo '<hr>';
                echo '<div class="buttonbox">';
                echo '<input type="hidden" name="uid" value="' . $user_id . '">';
                echo '<input type="hidden" name="identity" value="' . $user_identity . '">';
                echo '<input type="hidden" name="NotSAS" value="false">';
                echo '<input type="submit" value="儲存" class="leftbutton">';
                echo '<input type="button" value="返回" onclick="backtoSAS()" class="rightbutton">';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            } else {
                echo "找不到該用戶的資料。";
            }
        } else {
            echo "未提供用戶ID。";
        }
    ?>
</div>
</body>
</html>
