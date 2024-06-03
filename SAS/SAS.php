<?php
include('connection.php')
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="../css/SAS.css" rel="stylesheet" />
</head>
<body>
<div id="title">
    <h1>帳號資料總覽</h1>
    <hr>
</div>
<div id="search">
    <h4>條件篩選</h4>
    <form action="" method="get" class="searchForm">
        <select name="Search_identity" class="searchid">
            <option selected value="STL">請選擇身分</option>
            <option value="S">學生</option>
            <option value="T">教授/副教授</option>
            <option value="L">房東</option>
        </select>
        <input type="text" name="Search_name" placeholder="輸入姓名" class="searchname">
        <input type="submit" value="查詢" class="search" id="left_button">
        <input type="submit" value="重置" class="search" id="right_button">
    </form>
    <hr>
</div>
<div id="content">
    <?php
    if(!isset($_GET['Search_identity']) && !isset($_GET['Search_name'])){
        // 定義每頁顯示的資料筆數和當前頁數
        $per_page = 5;
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
            echo '<th>身分</th>';
            echo '<th>姓名</th>';
            echo '<th>帳號</th>';
            echo '</tr>';

            // 建立資料列
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $user_identity = "";
                $user_name = "";
                $user_account = "";
                if ($row["identity"] !== "SYS") {
                    switch ($row["identity"]) {
                        case 'T':
                            $user_account = $row["account"];
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
                    echo '<form action="SAS_UserDetails.php" method="post">';
                    echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
                    echo '<input type="hidden" name="identity" value="' . $row['identity'] . '">';
                    echo '<input type="submit" id="profilelink" value="' . $user_account . '">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
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
    }else{
        // 定義每頁顯示的資料筆數和當前頁數
        $per_page = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $Search_target = $_GET['Search_name'];
        switch ($_GET['Search_identity']) {
            case 'STL':
                $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity != 'SYS'";
                $result_count = $conn->query($sql_count);
                $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
                $total_pages = ceil($total_records / $per_page);
                $offset = ($current_page - 1) * $per_page;
                if ($Search_target == '') {
                    $sql_query = "SELECT * FROM user_profile WHERE identity != 'SYS' LIMIT $per_page OFFSET $offset";
                }else{
                    $sql_query = "SELECT * FROM user_profile WHERE identity != 'SYS'";
                }
                $result = $conn->query($sql_query);
                break;
            case 'S':
                $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity = 'S'";
                $result_count = $conn->query($sql_count);
                $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
                $total_pages = ceil($total_records / $per_page);
                $offset = ($current_page - 1) * $per_page;
                if ($Search_target == '') {
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'S' LIMIT $per_page OFFSET $offset";
                }else{
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'S'";
                }
                $result = $conn->query($sql_query);
                break;
            case 'T':
                $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity = 'T'";
                $result_count = $conn->query($sql_count);
                $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
                $total_pages = ceil($total_records / $per_page);
                $offset = ($current_page - 1) * $per_page;
                if ($Search_target == '') {
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'T' LIMIT $per_page OFFSET $offset";
                }else{
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'T'";
                }
                $result = $conn->query($sql_query);
                break;
            case 'L':
                $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity = 'L'";
                $result_count = $conn->query($sql_count);
                $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
                $total_pages = ceil($total_records / $per_page);
                $offset = ($current_page - 1) * $per_page;
                if ($Search_target == '') {
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'L' LIMIT $per_page OFFSET $offset";
                }else{
                    $sql_query = "SELECT * FROM user_profile WHERE identity = 'L'";
                }
                $result = $conn->query($sql_query);
                break;
        }
        if ($result->rowCount() > 0) {
            echo '<div id="tablebox">';
            echo '<table id="info_table">';
            echo '<tr>';
            echo '<th>身分</th>';
            echo '<th>姓名</th>';
            echo '<th>帳號</th>';
            echo '</tr>';

            // 建立資料列
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $user_identity = "";
                $user_name = "";
                $user_account = "";
                if ($row["identity"] !== "SYS") {
                    switch ($row["identity"]) {
                        case 'T':
                            $user_account = $row["account"];
                            $sql_query_2 = "select * from teacher_profile where t_uid='" . $row['uid'] . "'";
                            if ($Search_target !== "") {
                                $sql_query_2 .= " and t_name='" .$Search_target. "'";
                            }
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
                            $sql_query_2 = "select * from basicinfo where uid='" . $row['uid'] . "'";
                            if ($Search_target !== "") {
                                $sql_query_2 .= " and name='" .$Search_target. "'";
                            }
                            $result_2 = $conn->query($sql_query_2);
                            if ($result_2->rowCount() > 0) {
                                $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);     
                                $user_name = $row_2["name"];
                            }
                            break;
                        case 'L':
                            $user_identity = "房東";
                            $user_account = $row["account"];
                            $sql_query_2 = "select * from landlord where uid='" . $row['uid'] . "'";
                            if ($Search_target !== "") {
                                $sql_query_2 .= " and l_name='" .$Search_target. "'";
                            }
                            $result_2 = $conn->query($sql_query_2);
                            if ($result_2->rowCount() > 0) {
                                $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                                $user_name = $row_2["l_name"];
                            }
                            break;
                    }
                    if ($Search_target !== "" && $user_name == "") {
                        continue;
                    }
                    echo '<tr>';
                    echo '<td>' . $user_identity . '</td>';
                    echo '<td>' . $user_name . '</td>';
                    echo '<td>';
                    echo '<form action="SAS_UserDetails.php" method="post">';
                    echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
                    echo '<input type="hidden" name="identity" value="' . $row['identity'] . '">';
                    echo '<input type="submit" id="profilelink" value="' . $user_account . '">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }

            // 建立 HTML 表格的結束標籤
            echo '</table>';
            echo '</div>';
            echo '<div id="pagination">';
            echo '<ul class="pagination">';
            // 顯示上一頁按鈕
            echo '<li><a href="?page=' . ($current_page - 1) . '&Search_identity='.$_GET['Search_identity'].'&Search_name='.$_GET['Search_name']. '" class="' . ($current_page == 1 ? 'disabled' : '') . '">上一頁</a></li>';
            // 顯示數字頁碼按鈕
            /*for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
            }*/
            // 顯示下一頁按鈕
            echo '<li><a href="?page=' . ($current_page + 1) . '&Search_identity='.$_GET['Search_identity'].'&Search_name='.$_GET['Search_name']. '" class="' . ($current_page == $total_pages ? 'disabled' : '') . '">下一頁</a></li>';
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
