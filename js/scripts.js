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
    var message = '發生內部錯4誤';
    alert(message);
    window.location.href='SAS.php';
}
function warning5(){
    var message = '發生內部錯誤5';
    window.location.href='SAS_UserDelete.php';
}
function warning6(){
    var message = '發生內部錯誤6';
    window.location.href='SAS_UserDelete.php';
}
function logoutmsg(){
    var message = '已從系統登出';
    alert(message);
    window.location.href="index.php";
}
function updatemsgForSAS(){
    var message = '已更新資料';
    alert(message);
    window.location.href="SAS.php";
}
function updatemsg(){
    var message = '已更新資料';
    alert(message);
    window.top.location.href="../lobby.php";
}
function updatemsg_relog(){
    var message = '已更新資料，請重新登入';
    alert(message);
    window.top.location.href="../logoutprocess.php";
}
function createmsg(){
    var message = '已新增資料';
    alert(message);
    window.location.href="SAS.php";
}
function signmissing(){
    var message = '驗證遺失';
    alert(message);
    window.location.href="lobby.php";
}
////////////////////////////////////////
function showiframe1(){
    var iframe = document.getElementById('user_profile');
    var disableiframe1 = document.getElementById('user_delete');
    iframe.style.display = 'block';
    disableiframe1.style.display = 'none';
}
function showiframe2(){
    var iframe = document.getElementById('user_delete');
    var disableiframe1 = document.getElementById('user_profile');
    iframe.style.display = 'block';
    disableiframe1.style.display = 'none';
}
function showiframe3(){
    var iframe = document.getElementById('personaluserdetail');
    iframe.style.display='block';
}
function showiframe4(){
    var iframe = document.getElementById('createaccountchoice');
    var disableiframe1 = document.getElementById('user_profile');
    var disableiframe2 = document.getElementById('user_delete');
    var disableiframe3 = document.getElementById('createmassiveaccountchoice');
    iframe.style.display='block';
    disableiframe1.style.display='none';
    disableiframe2.style.display='none';
    disableiframe3.style.display='none';
}
function showiframe5(){
    var iframe = document.getElementById('createmassiveaccountchoice');
    var disableiframe1 = document.getElementById('user_profile');
    var disableiframe2 = document.getElementById('user_delete');
    var disableiframe3 = document.getElementById('createaccountchoice');
    iframe.style.display='block';
    disableiframe1.style.display='none';
    disableiframe2.style.display='none';
    disableiframe3.style.display='none';
}
////////////////////////////////////////
function backtoSAS(){
    window.location.href='SAS.php';
}
function backtolobby(){
    window.top.location.href="../lobby.php";
}
////////////////////////////////////////
function deleteconfirm(){
    var confirmation = confirm('是否刪除該使用者帳號?');
    if(confirmation){
        return true;
    }else{
        alert('已取消操作');
        window.location.href='SAS_UserDelete.php';
        return false;
    }
}
function deletemsg(){
    var message = '已刪除資料';
    alert(message);
    window.location.href="SAS_UserDelete.php";
}
////////////////////////////////////////
function updateconfirm(){
    var confirmation = confirm('是否更改該使用者帳號資訊?');
    if(confirmation){
        return true;
    }else{
        alert('已取消操作');
        history.go(0);
        return false;
    }
}
////////////////////////////////////////
function createconfirm(){
    var confirmation = confirm('是否新增此筆使用者帳號?');
    if(confirmation){
        return true;
    }else{
        alert('已取消操作');
        return false;
    }
}
////////////////////////////////////////
function PermissionEditConfirm(){
    var confirmation = confirm('是否更改該使用者帳號權限?');
    if(confirmation){
        return true;
    }else{
        alert('已取消操作');
        return false;
    }
}
function updatemsg_permission(){
    var message = '已更新權限';
    alert(message);
    window.location.href="SAS_UserPermissionEdit.php";
}
////////////////////////////////////////
function login_invalid(){
    var message = '此帳號已被凍結，請與網站管理員聯繫。\n連絡電話：0800-000-000。';
    alert(message);
    window.location.href="index.php";
}
////////////////////////////////////////