<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台-帳號管理</title>
    <link href="../css/SAS_CreateMassiveAccountChoice.css" rel="stylesheet" />
</head>
<body>
    <div class="content">
        <div class="instruction-container">
            <div class="instruction">
                <h1>請選擇要大量新增的使用者身分</h1>
                <hr>
            </div>
        </div>
        <form action="SAS_CreateMassiveAccount.php" method="post">
            <div id="choice_container">
                <button type="submit" class="button" name="identity" value="S"><span>學生</span></button>
                <button type="submit" class="button" id="rightbutton" name="identity" value="T"><span>教師</span></button>
                <button type="submit" class="button" id="rightbutton" name="identity" value="L"><span>房東</span></button>
            </div>
        </form>
    </div>
</body>
</html>