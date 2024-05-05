<?php

include("connection.php");

$select_db = @mysql_select_db("rentsystem");
if(!$select_db) {
    echo '<br>找不到数据库!<br>';
} else {
    //獲取前端船的變數
    if (isset($_POST['uid']) && isset($_POST['articleID'])) {
        $uid = $_POST['uid'];
        $articleID = $_POST['articleID'];

        //查資料
        $sql_query = "SELECT keepnum FROM `contact article` WHERE articleID = '$articleID'";
        $result = mysql_query($sql_query);
        $row = mysql_fetch_assoc($result);
        $keepnum = $row['keepnum'];

        //收藏數+1
        $keepnum++;
        $update_query = "UPDATE `contact article` SET keepnum = $keepnum WHERE articleID = '$articleID'";
        $sql_query_insert = "INSERT INTO user_keep_article (uid, articleID) VALUES ('$uid', '$articleID')";
        //更新並新增到使用者收藏
        if (mysql_query($update_query)) {
            mysql_query($sql_query_insert);
            // 回傳
            echo $keepnum;
        } else {
            echo "更新收藏数失败: " . mysql_error();
            // 在此处进行处理，更新数据库等操作
        }
    } else {
        // 如果未收到 uid 或 articleID，可以返回错误信息
        echo "未收到用户ID或文章ID";
    }
}
?>
