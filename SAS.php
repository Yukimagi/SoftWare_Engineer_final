<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台-帳號管理</title>
    <link href="css/lobby.css" rel="stylesheet" />
    <style>
        .content table {
            margin: 3% auto; /* 讓表格置中 */
            border-collapse: collapse; /* 合併邊框 */
        }

        .content th,
        .content td {
            border: 1px solid black; /* 添加框線 */
            padding: 8px; /* 設置儲存格內距 */
            text-align: center;
        }
        div table {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php
    session_start(); // 啟動 session

    // 檢查使用者是否已登入，如果未登入則重新導向到其他頁面
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: index01.php'); // 重新導向到登入頁面
        exit; // 終止程式執行
    }
    
    // 從 session 中獲取使用者的身份和 ID
    $identity = $_SESSION['identity'];
    $uid = $_SESSION['uid'];
    $name = $_SESSION['name'];
    ?>


    <header>
        <h1>租屋管理系統</h1>
    </header>
    <nav>
        <h2>功能選單</h2>
        <ul>
            <div>
                <li><a href="lobby.php">首頁</a></li>
            </div>
            <?php
            $managementlist = '
                <div id="management_function">
                    <span><li><a href="SAS.php">後台 - 帳號管理</a></li></span>
                    <div class="option">
                        <li><a href="SAS_CreateAccountChoice.php" id="sys_function">新增使用者帳戶</a></li>
                        <li><a href="#" id="sys_function">新增大量帳戶</a></li>
                        <li><a href="#" id="sys_function">刪除使用者帳戶</a></li>
                        <li><a href="#" id="sys_function">變更使用者權限</a></li>
                    </div>
                </div>
            ';
            if (isset($identity) && $identity === "SYS") {
                echo $managementlist;
            }
            ?>
            <div>
                <li><a href="#">租屋管理</a></li>
            </div>
            <div>
                <li><a href="#">交流平台</a></li>
            </div>
            <div>
                <li><a href="#">廣告平台</a></li>
            </div>
            <?php
            if (isset($identity) && $identity !== "SYS") {
                echo ' <li><a href="#">個人帳戶管理</a></li>';
            }
            ?>
            <!-- 添加更多功能連結 -->
            <hr> <!-- 添加分隔線 -->
            <p>現在身分為：
                <?php
                if (isset($identity) && $identity === "SYS") {
                    echo '<span style="color:#b0c4de; display: inline;">系統管理員</span>';
                }
                elseif (isset($identity) && $identity === "T") {
                    echo '<span style="color:#b0c4de; display: inline;">教師</span>';
                }
                elseif (isset($identity) && $identity === "S") {
                    echo '<span style="color:#b0c4de; display: inline;">學生</span>';
                }
                elseif (isset($identity) && $identity === "L") {
                    echo '<span style="color:#b0c4de; display: inline;">房東</span>';
                }


                if (isset($identity) && $identity !== "SYS") {
                    echo '<br>';
                    echo '使用者姓名：<span style="color:#b0c4de; display: inline;">' . $name . '</span>';
                }
                ?>
            </p>
            <li class="LoginLink"><a href="logoutprocess.php">使用者登出</a></li>
        </ul>
    </nav>
    <div class="content">
        <?php
            include("connection.php");

            // 定義每頁顯示的資料筆數和當前頁數
            $per_page = 8;
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            // 計算總資料筆數
            $sql_count = "SELECT COUNT(*) AS total FROM user_profile WHERE identity != 'SYS'";
            $result_count = $conn->query($sql_count);
            $total_records = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
            // 計算總頁數
            $total_pages = ceil($total_records / $per_page);
            // 計算偏移量
            $offset = ($current_page - 1) * $per_page;
            // 查詢資料
            $sql_query = "SELECT * FROM user_profile WHERE identity != 'SYS' LIMIT $per_page OFFSET $offset";
            $result = $conn->query($sql_query);


            //$sql_query = "select * from user_profile";
           //$result = $conn->query($sql_query);
            if ($result->rowCount() > 0) {
                // 建立 HTML 表格的開始標籤
                echo '<table>';
            
                // 建立表頭
                echo '<tr>';
                echo '<th style="width: 20%;">身分</th>';
                echo '<th style="width: 20%;">姓名</th>';
                echo '<th style="width: 60%;">帳號</th>';
                echo '</tr>';

                $user_identity = "";
                $user_name = "";
                $user_account = "";
            
                // 建立資料列
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    if ($row["identity"] !== "SYS") {
                        switch ($row["identity"]) {
                            case 'T':
                                $sql_query_2 = "select * from teacher_profile where t_uid='" . $row['uid'] . "'";
                                $result_2 = $conn->query($sql_query_2);
                                if ($result_2->rowCount() > 0) {
                                    $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                                    $user_identity = $row_2["t_rank"];
                                    $user_name = $row_2["t_name"];
                                    $user_account = $row["account"];
                                }
                                break;
                            case 'S':
                                $sql_query_2 = "select * from basicinfo where uid='" . $row['uid'] . "'";
                                $result_2 = $conn->query($sql_query_2);
                                if ($result_2->rowCount() > 0) {
                                    $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                                    $user_identity = "學生";
                                    $user_name = $row_2["name"];
                                    $user_account = $row["account"];
                                }
                                break;
                            case 'L':
                                $sql_query_2 = "select * from landlord where uid='" . $row['uid'] . "'";
                                $result_2 = $conn->query($sql_query_2);
                                if ($result_2->rowCount() > 0) {
                                    $row_2 = $result_2->fetch(PDO::FETCH_ASSOC);
                                    $user_identity = "房東";
                                    $user_name = $row_2["l_name"];
                                    $user_account = $row["account"];
                                }
                                break;
                        }
                        echo '<tr>';
                        echo '<td>' . $user_identity . '</td>';
                        echo '<td>' . $user_name . '</td>';
                        //echo '<td><a href="SAS_UserDetails.php?id=' . $row['uid'] . '">' . $user_account . '</a></td>';
                        echo '<td>';
                        echo '<form action="SAS_UserDetails.php" method="post">';
                        echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
                        echo '<input type="hidden" name="identity" value="' . $row['identity'] . '">';
                        echo '<input type="submit" value="' . $user_account . '" style=
                        "background: none; border: none; color: blue; text-decoration: underline; cursor: pointer; font-size:18px;">';
                        echo '</form>';
                        echo '</td>';

                        echo '</tr>';
                    }
                }
            
                // 建立 HTML 表格的結束標籤
                echo '</table>';
                echo '<div class="pagination">';
                echo '<ul>';
                // 顯示上一頁按鈕
                if ($current_page > 1) {
                    echo '<li><a href="?page=' . ($current_page - 1) . '">上一頁</a></li>';
                }
                // 顯示數字頁碼按鈕
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                }
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