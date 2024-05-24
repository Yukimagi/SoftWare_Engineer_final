
<?php
include('connection.php')
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="../css/SAS_ApplicationCensor.css" rel="stylesheet" />
    <script src="../js/scripts.js"></script>
    <style>

    </style>
</head>
<body>
<div id="title">
    <h1>租屋管理系統</h1>
    <hr>
</div>
<div id="content">
    <?php
    $per_page = 3;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sql_count = "SELECT COUNT(*) AS total FROM account_applications";
    $result_count = $conn->query($sql_count);
    $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_records / $per_page);
    $offset = ($current_page - 1) * $per_page;
    $sql_query = "SELECT * FROM account_applications LIMIT $per_page OFFSET $offset";
    $result = $conn->query($sql_query);

    if ($result->rowCount() > 0) {
        echo '<div id="tablebox">';
        echo '<table id="info_table">';
            echo '<tr>';
                echo '<th>申請序號</th>';
                echo '<th>姓名</th>';
                echo '<th>審核狀態</th>';
                echo '</tr>';

            // 建立資料列
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $apply_id = $row['id'];
                $apply_name = $row['name'];
                $apply_status = $row['status'];

                echo '<tr>';
                echo '<td>' . $apply_id . '</td>';
                echo '<td>' . $apply_name . '</td>';
                echo '<td>' . $apply_status . '</td>';
                echo '</tr>';
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