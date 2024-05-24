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
    <link href="../css/SAS_ApplicationsDetails.css" rel="stylesheet" />
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
                $apply_profile = $result->fetch(PDO::FETCH_ASSOC);
                echo "<h1>詳細申請資料</h1>";// 在這裡顯示用戶詳細資料
                echo "<hr>";
                echo '<div class="profile_form">';
                    echo '<div id="left_container">';
                        echo '<table id="reason_info">';
                        echo '<tr>';
                        echo '<th>申請原因</th>';
                        echo '</tr>';
                        echo '<td>'.$apply_profile['reason'].'</td>';
                        echo '</table>';
                    echo '</div>';
                    echo '<div id="right_container">';
                        echo '<div id="top_container">';
                            echo '<table id="profile_info">';
                            echo '<tr>';
                            echo '<th>申請人姓名</th>';
                            echo '</tr>';
                            echo '<td>'.$apply_profile['name'].'</td>';
                            echo '<tr>';
                            echo '<th>申請人電話</th>';
                            echo '</tr>';
                            echo '<td>'.$apply_profile['phone'].'</td>';
                            echo '<tr>';
                            echo '<th>案件狀態</th>';
                            echo '</tr>';
                            if ($apply_profile['status'] == "pending") {
                                echo '<td class="status pending">'. $apply_profile['status'] .'</td>';
                            } elseif ($apply_profile['status'] == "approved") {
                                echo '<td class="status approved">'. $apply_profile['status'] .'</td>';
                            } elseif ($apply_profile['status'] == "rejected") {
                                echo '<td class="status rejected">'. $apply_profile['status'] .'</td>';
                            }
                            echo '</table>';
                        echo '</div>';
                        echo '<div id="bottom_container">';
                            echo '<form action="SAS_SQLApplication.php" method="post">';
                            echo '<input type="hidden" name="id" value="' . $apply_id . '">';
                            echo '<input type="submit" class="button" name="approval" value="通過" id="access">';
                            echo '<br>';
                            echo '<input type="submit" class="button" name="approval" value="駁回" id="deny">';
                            echo '<br>';
                            echo '<input type="button" class="button" value="返回" id="backtocensor" onclick="backtocensor()">';
                            echo '<br>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
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
