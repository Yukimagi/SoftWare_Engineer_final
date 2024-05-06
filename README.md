# SoftWare_Engineer_final
##### 2024/5/5 完成merge首頁與登入並製作CPS 首頁、template等等...功能
## connection.php範本
'''php
<?php
//連結資料庫
$location="localhost";//連結本機
$account="";//帳號
$password="";//密碼
if(isset($location)&&isset($account)&&isset($password))
{
$link=mysql_pconnect($location,$account,$password);//mysql_pconnect連結狀況給link
if(!$link)
{
echo'無法連結資料庫';
exit();
}
else
echo '';
}
?>
'''
