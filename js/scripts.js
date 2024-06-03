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
function applicationsgranted(){
    var message = '已核准該申請';
    alert(message);
    window.location.href='SAS_ApplicationCensor.php';
}
function applicationsdenied(){
    var message = '已否決該申請';
    alert(message);
    window.location.href='SAS_ApplicationCensor.php';


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


function iframemanipulate(currentIframeIndex){
    const  iframes = document.querySelectorAll('iframe')
    iframes.forEach((iframe, index) =>{
        if (index === currentIframeIndex){
            iframe.style.display = 'block';
        }else{
            iframe.style.display = 'none';
        }
    })
}
function showiframe1(){
    var currentIframeIndex = 0;
    iframemanipulate(currentIframeIndex);
}
function showiframe2(){
    var currentIframeIndex = 1;
    iframemanipulate(currentIframeIndex);
}
function showiframe3(){
    var currentIframeIndex = 2;
    iframemanipulate(currentIframeIndex);
}
function showiframe4(){
    var currentIframeIndex = 3;
    iframemanipulate(currentIframeIndex);
}
function showiframe5(){
    var currentIframeIndex = 4;
    iframemanipulate(currentIframeIndex);
}
function showiframe6(){
    var currentIframeIndex = 5;
    iframemanipulate(currentIframeIndex);
}
function showiframe7(){
    var currentIframeIndex = 6;
    iframemanipulate(currentIframeIndex);


}
////////////////////////////////////////
function backtoSAS(){
    window.location.href='SAS.php';
}
function backtolobby(){


    window.top.location.href="../lobby.php";
}
function backtoindex(){
    window.location.href="index.php";
}
function backtocensor(){
    window.location.href='SAS_ApplicationCensor.php';


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
function registermsg(id){
    var message = '申請訊息已送出，請靜待管理員回復。\n審核過程可能需要1~3個工作天\n';
    message += '您的案件編號為：' + id;
    message += '，請記住以上案件編號以便後續進度查詢';
    alert(message);
    window.location.href="index.php";
}
function id_check(){
    var id = prompt("請輸入案件編號 (e.g. ap00001)：");
    if (id != null) {
        window.location.href="SAS/SAS_SQLApplicationStatusCheck.php?ap=" + id;
    }
}
function result_pending(){
    var message = '您的申請案件目前正在審理中。\n注意：審核過程可能需要1~3個工作天';
    alert(message);
    window.location.href="../registerindex.php";
}
function result_approved(){
    var message = '恭喜！\n您的申請案件已通過審核';
    alert(message);
    window.location.href="../registerindex.php";
}
function result_rejected(){
    var message = '很遺憾，您的申請案件已遭到駁回。\n請重新審視自己的個人簡介，並再度提出申請';
    alert(message);
    window.location.href="../registerindex.php";
}

