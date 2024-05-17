<?php
include('connection.php')
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="css/SAS_UserPermissionEdit.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
    <style>
        
    </style>
</head>
<body>
<div id="title">
    <h1>帳號權限變更</h1>
    <hr>
</div>
<div id="content">
    <?php
    // 定義每頁顯示的資料筆數和當前頁數
    $per_page = 3;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity != 'SYS'";
    $result_count = $conn->query($sql_count);
    $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_records / $per_page);
    $offset = ($current_page - 1) * $per_page;
    $sql_query = "SELECT * FROM user_profile WHERE identity != 'SYS' LIMIT $per_page OFFSET $offset";
    $result = $conn->query($sql_query);

    if ($result->rowCount() > 0) {
        echo '<div id="tablebox">';
        echo '<table id="info_table">';
        echo '<tr>';
        echo '<th class="title">身分</th>';
        echo '<th class="title">姓名</th>';
        echo '<th class="title">帳號</th>';
        echo '<th class="title">權限</th>';
        echo '<th class="delete">權限變更</th>';
        echo '</tr>';

        // 建立資料列
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $user_identity = "";
            $user_name = "";
            $user_account = "";
            $user_status = "";
            if ($row["identity"] !== "SYS") {
                switch ($row["identity"]) {
                    case 'T':
                        $user_account = $row["account"];
                        $user_status = $row["status"];
                        $sql_query_2 = "select * from teacher_profile where t_uid='" . $row['uid'] . "'";
                        $result_2 = $conn->query($sql_query_2);
                        if ($result_2->rowCount() > 0) {
                            $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                            $user_identity = $row_2["t_rank"];
                            $user_name = $row_2["t_name"];
                        }
                        break;
                    case 'S':
                        $user_identity = "學生";
                        $user_account = $row["account"];
                        $user_status = $row["status"];
                        $sql_query_2 = "select * from basicinfo where uid='" . $row['uid'] . "'";
                        $result_2 = $conn->query($sql_query_2);
                        if ($result_2->rowCount() > 0) {
                            $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                            $user_name = $row_2["name"];
                        }
                        break;
                    case 'L':
                        $user_identity = "房東";
                        $user_account = $row["account"];
                        $user_status = $row["status"];
                        $sql_query_2 = "select * from landlord where uid='" . $row['uid'] . "'";
                        $result_2 = $conn->query($sql_query_2);
                        if ($result_2->rowCount() > 0) {
                            $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                            $user_name = $row_2["l_name"];
                        }
                        break;
                }
                echo '<tr>';
                echo '<td>' . $user_identity . '</td>';
                echo '<td>' . $user_name . '</td>';
                echo '<td>';
                echo '<form action="SAS_SQLPermissionEdit.php" method="post" onsubmit="return PermissionEditConfirm()">';
                echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
                echo '<input type="hidden" name="status" value="' . $row['status'] . '">';
                echo  $user_account;
                echo '</td>';
                if ($user_status == "VALID") {
                    echo '<td class="status valid">'. $user_status .'</td>';
                } else {
                    echo '<td class="status invalid">'. $user_status .'</td>';
                }
                echo '<td>';
                echo '<input type="submit" value="變更"></td>';
                echo '</form>';
                echo '</tr>';
            }
        }

        // 建立 HTML 表格的結束標籤
        echo '</table>';
        echo '</div>';
        echo '<div id="pagination">';
        echo '<ul>';
        // 顯示上一頁按鈕
        if ($current_page > 1) {
            echo '<li><a href="?page=' . ($current_page - 1) . '">上一頁</a></li>';
        }
        // 顯示數字頁碼按鈕
        /*for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
        }*/
        // 顯示下一頁按鈕
        if ($current_page < $total_pages) {
            echo '<li><a href="?page=' . ($current_page + 1) . '">下一頁</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo '沒有找到資料。';
    }
    ?>
</div>
</body>
</html>
