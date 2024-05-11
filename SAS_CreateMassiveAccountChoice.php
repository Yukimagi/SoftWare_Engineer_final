<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台-帳號管理</title>
    <link href="css/lobby.css" rel="stylesheet" />
    <style>
        .instruction-container {
            position: absolute;
            top: 16%;
            left: 44%;
        }

        .instruction {
            padding: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #000;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .button-container {
            display: flex;
            flex-wrap: nowrap; /* 避免換行 */
            justify-content: space-between;
            width: 100%; /* 調整為足夠寬度 */
            margin-top: -70px;
        }

        .button {
            min-width: 200px;
            min-height: 200px;
            background-color: #fff;
            border: 0;
            border-radius: 5px;
            border-bottom: 4px solid #d9d9d9;
            font-size: 1rem;
            text-align: center;
            text-decoration: none;
            box-shadow: 0px 5px 10px #0057ab;
            transition: all 0.3s;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            margin: 0 75px; /* 調整按鈕之間的間距 */
        }

        .button:hover {
            box-shadow: 0px 15px 25px -5px #0057ab;
            transform: scale(1.03);
            background-color: lightcyan; /* 修改背景色 */
        }

        .button:active {
            box-shadow: 0px 4px 8px #0065c8;
            transform: scale(0.98);
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
                        <li><a href="SAS_CreateMassiveAccountChoice.php" id="sys_function">新增大量帳戶</a></li>
                        <li><a href="SAS_UserDelete.php" id="sys_function">刪除使用者帳戶</a></li>
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
        <div class="instruction-container">
            <div class="instruction">請選擇要大量新增的使用者身分</div>
        </div>
        <form action="SAS_CreateMassiveAccount.php" method="post">
            <div class="button-container">
                <button type="submit" class="button" name="identity" value="S">學生</button>
                <button type="submit" class="button" name="identity" value="T">教師</button>
                <?php//<button type="submit" class="button" name="identity" value="SYS">系統管理者</button>?>
                <button type="submit" class="button" name="identity" value="L">房東</button>
            </div>
        </form>
    </div>
</body>
</html>