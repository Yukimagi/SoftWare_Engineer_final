<?php
include ('connection.php')
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="css/SAS.css" rel="stylesheet" />
</head>
<body>
<div id="title">
    <h1>帳號資料總覽</h1>
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
       echo '<th>身分</th>';
       echo '<th>姓名</th>';
       echo '<th>帳號</th>';
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
