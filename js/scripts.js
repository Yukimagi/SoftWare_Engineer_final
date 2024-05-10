/*!
* Start Bootstrap - Blog Home v5.0.7 (https://startbootstrap.com/template/blog-home)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-blog-home/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
function warning1(){
    var message = '帳號或密碼錯誤';
    alert(message);
    window.location.href='loginindex.php';
}
function warning2(){
    var message = '發生內部錯誤';
    alert(message);
    window.location.href='loginindex.php';
}
function warning3(){
    var message = '發生內部錯誤3';
    alert(message);
    window.location.href='SAS.php';
}
function warning4(){
    var message = '發生內部錯誤4';
    alert(message);
    window.location.href='SAS.php';
}
function logoutmsg(){
    var message = '已從系統登出';
    alert(message);
    window.location.href="index.php";
}
function updatemsg(){
    var message = '已更新資料';
    alert(message);
    window.location.href="SAS.php";
}
////////////////////////////////////////
function showiframe1(){
    var iframe = document.getElementById('user_profile');
    iframe.style.display = 'block';
}
function backtoSAS(){
    window.location.href='SAS.php';
}
