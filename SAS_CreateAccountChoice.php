<!DOCTYPE>
<html lang="zh-Hant" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台-帳號管理</title>
    <link href="css/SAS_CreateAccountChoice.css" rel="stylesheet" />
</head>
<body>
    <div class="content">
        <div class="instruction-container">
            <div class="instruction">
                <h1>請選擇要新增的使用者身分</h1>
                <hr>
            </div>
        </div>
        <form action="SAS_CreateAccount.php" method="post">
            <div id="choice_container">
                <button type="submit" class="button" name="identity" value="S"><span>學生</span></button>
                <button type="submit" class="button" id="rightbutton" name="identity" value="T"><span>教師</span></button>
                <?php //<button type="submit" class="button" name="identity" value="SYS">系統管理者</button>?>
                <button type="submit" class="button" id="rightbutton" name="identity" value="L"><span>房東</span></button>
            </div>
        </form>
    </div>
</body>
</html>