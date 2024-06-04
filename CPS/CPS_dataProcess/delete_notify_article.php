<?php

include("../../connection.php");

$select_db = @mysql_select_db("rentsystem");
if(!$select_db) {
    echo '<br>找不到数据库!<br>';
} else {
    //獲取前端船的變數
    if (isset($_POST['uid']) && isset($_POST['articleID'])&& isset($_POST['email'])) {
        $uid = $_POST['uid'];
        $articleID = $_POST['articleID'];
        $email = $_POST['email'];
        $articleIname="";
        //找資料
        $sql_query = "SELECT `articleIname` FROM `contact article` WHERE articleID = '$articleID'";
        $result = mysql_query($sql_query);
        while ($row = mysql_fetch_assoc($result)) {
            $articleIname = $row['articleIname'];
        }
        //刪資料
        $sql_query = "DELETE FROM `contact article` WHERE articleID = '$articleID'";
        $result = mysql_query($sql_query);

        //寄信
        $subject = "您的文章: ".$articleIname." 不符合規範";
        $message = "您的文章: ".$articleIname." 已被刪除，原因為不符合規範。";
        $headers = "From: a1105505@mail.nuk.edu.tw";
        $sql_query_insert = "INSERT INTO user_article_error (uid, error) VALUES ('$uid', '$message')";
        $result2 = mysql_query($sql_query_insert);

        
    } else {
        
        echo "未收到用戶ID或文章ID";
    }
}
?>
