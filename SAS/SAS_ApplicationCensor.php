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
    <h1>帳號申請審核</h1>
    <hr>
</div>
<div id="search">
    <h4>條件篩選</h4>
    <form action="" method="get" class="searchForm">
        <select name="Search_status" class="searchstatus">
            <option selected value="all">請選擇審核狀態</option>
            <option value="pending">pending(審核中)</option>
            <option value="approved">approved(已通過)</option>
            <option value="rejected">rejected(已駁回)</option>
        </select>
        <input type="text" name="Search_id" placeholder="輸入案件編號" class="searchid">
        <input type="submit" value="查詢" class="search" id="left_button">
        <input type="submit" value="重置" class="search" id="right_button">
    </form>
    <hr>
</div>
<div id="content">
    <?php
    if(!isset($_GET['Search_status']) && !isset($_GET['Search_id'])){
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
                    echo '<td>';
                    echo '<form action="SAS_ApplicationsDetails.php" method="post">';
                    echo '<input type="hidden" name="apply_id" value="' . $apply_id . '">';
                    echo '<input type="submit" id="profilelink" value="' . $apply_id . '">';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>' . $apply_name . '</td>';
                    if ($apply_status == "pending") {
                        echo '<td class="status pending">'. $apply_status .'</td>';
                    } elseif ($apply_status == "approved") {
                        echo '<td class="status approved">'. $apply_status .'</td>';
                    } elseif ($apply_status == "rejected") {
                        echo '<td class="status rejected">'. $apply_status .'</td>';
                    }
                    echo '</tr>';
                }
                // 建立 HTML 表格的結束標籤
            echo '</table>';
            echo '</div>';
            echo '<div id="pagination">';
            echo '<ul class="pagination">';
            // 顯示上一頁按鈕
            echo '<li><a href="?page=' . ($current_page - 1) . '" class="' . ($current_page == 1 ? 'disabled' : '') . '">上一頁</a></li>';
            // 顯示下一頁按鈕
            echo '<li><a href="?page=' . ($current_page + 1) . '" class="' . ($current_page == $total_pages ? 'disabled' : '') . '">下一頁</a></li>';
            echo '</ul>';
            echo '</div>';
        } else {
        echo '沒有找到資料。';
        }
    } else{
        $status = $_GET['Search_status'];
        $id = $_GET['Search_id'];

        $per_page = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sql_count = "SELECT COUNT(*) AS total FROM account_applications";
        if ($status !== "all") {
            $sql_count .= " WHERE status = '" . $status . "'";
        }
        $result_count = $conn->query($sql_count);
        $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_records / $per_page);
        $offset = ($current_page - 1) * $per_page;
        $sql_query = "SELECT * FROM account_applications";
        if ($status !== "all") {
            $sql_query .= " WHERE status = '" . $status . "'";
        }
        if ($status == "all" && $id !== "") {
            $sql_query .= " WHERE id='" .$id. "'";
        } elseif ($id !== "") {
            $sql_query .= " and id='" .$id. "'";
        }
        $sql_query .= " LIMIT $per_page OFFSET $offset";
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
                    echo '<td>';
                    echo '<form action="SAS_ApplicationsDetails.php" method="post">';
                    echo '<input type="hidden" name="apply_id" value="' . $apply_id . '">';
                    echo '<input type="submit" id="profilelink" value="' . $apply_id . '">';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>' . $apply_name . '</td>';
                    if ($apply_status == "pending") {
                        echo '<td class="status pending">'. $apply_status .'</td>';
                    } elseif ($apply_status == "approved") {
                        echo '<td class="status approved">'. $apply_status .'</td>';
                    } elseif ($apply_status == "rejected") {
                        echo '<td class="status rejected">'. $apply_status .'</td>';
                    }
                    echo '</tr>';
                }
            // 建立 HTML 表格的結束標籤
            echo '</table>';
            echo '</div>';
            echo '<div id="pagination">';
            echo '<ul class="pagination">';
            // 顯示上一頁按鈕
            echo '<li><a href="?page=' . ($current_page - 1) . '&Search_status='.$status.'&Search_id='.$id. '" class="' . ($current_page == 1 ? 'disabled' : '') . '">上一頁</a></li>';
            // 顯示數字頁碼按鈕
            /*for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
            }*/
            // 顯示下一頁按鈕
            echo '<li><a href="?page=' . ($current_page + 1) . '&Search_status='.$status.'&Search_id='.$id. '" class="' . ($current_page == $total_pages ? 'disabled' : '') . '">下一頁</a></li>';
            echo '</ul>';
            echo '</div>';
        } else {
        echo '沒有找到資料。';
        }
    }
    ?>
</div>
</body>
</html>