<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CPS</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
            <!-- 引入 Bootstrap CSS -->
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
        .vertical-line {
          border-left: 1px solid #808080; /* 顏色與寬度等 */
          height: 50px; /* 線的長度 */
          margin: 0 20px; /* 位置 */
        }
        .center {
            margin: 0 auto; /* 居中 */
            width: 70%; 
        }
        </style>
    </head>
    <body>
        <?php
        //連結資料庫
        include("../connection.php");
        ?>
        <?php
            session_start(); // 啟動 session

            // 檢查使用者是否已登入，如果未登入則重新導向到其他頁面
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $identity = "訪客";
                $uid = "None";
            }
            else{
            // 從 session 中獲取使用者的身份和 ID
            $identity = $_SESSION['identity'];
            $uid = $_SESSION['uid'];
            }

            if (isset($identity) && $identity !== "SYS" && $identity !== "訪客") {

                switch ($identity){
                    case "S":
                        $sql_query = "select name from basicinfo where uid='" . $uid . "'";
                        break;
                    case "T":
                        $sql_query = "select t_name as name from teacher_profile where t_uid='" . $uid . "'";
                        break;
                    case "L":
                        $sql_query = "select l_name as name from landlord where uid='" . $uid . "'";
                        break;
                }
                $result = mysql_query($sql_query);
                $row = mysql_fetch_array($result);
                $name = $row["name"];
            }
            ?>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="../CPS_Home.php">CPS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../index02.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_Communicate.php">交流平台</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../index01.php?logged_in=false">使用者登出</a></li>';
                        }
                        ?>
                        <div class="vertical-line"></div><!-- 畫垂直線-->
                        <p><span style="color:#b0c4de; display: inline;">現在身分為：</span>
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
                    elseif(isset($identity) && $identity === "訪客") {
                        echo '<span style="color:#b0c4de; display: inline;">訪客</span>';
                    }

                    if (isset($identity) && $identity !== "SYS"&& $identity !== "訪客") {
                        echo '<br>';
                        echo '<span style="color:#b0c4de; display: inline;">使用者姓名：</span><span style="color:#b0c4de; display: inline;">' . $name . '</span>';
                    }
                ?>
            </p>
            
            
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">新增物件</h1>
                    
                </div>
            </div>
        </header>
        <?php
        $name = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $select_db = @mysql_select_db("rentsystem"); // 選擇資料庫
            if (!$select_db) {
                echo '<br>找不到資料庫!<br>';
            } 
            else {
                // 檢查名稱是否已存在於資料庫
                $check_query = "SELECT COUNT(*) AS existing_rows FROM `contact_object` WHERE `name` = '$name'";
                $check_result = mysql_query($check_query);
                $check_row = mysql_fetch_assoc($check_result);
                $existing_rows = $check_row['existing_rows'];

                if ($existing_rows > 0) {
                    // 如果名稱已存在，顯示提示訊息並結束程式
                    echo "<script>alert('此物件已存在!');</script>";
                    //echo "<p>此物件已存在!</p>";
                } else {
                    // 如果名稱不存在，則執行插入新物件到資料庫的操作
                    $sql_query = "SELECT COUNT(*) AS total_rows FROM `contact_object`";
                    $result = mysql_query($sql_query);
                    $row = mysql_fetch_assoc($result);
                    $total_rows = $row['total_rows'];

                    if ($total_rows == 0) {
                        $new_id = "O00000";
                    } else {
                        // db是否有data
                        $sql_query = "SELECT MAX(objID) AS max_id FROM `contact_object`";
                        $result = mysql_query($sql_query);
                        $row = mysql_fetch_array($result);
                        $max_id = $row["max_id"];
                        $new_id = "O" . str_pad(substr($max_id, 1) + 1, 5, "0", STR_PAD_LEFT);
                    }

                    // 插入新物件到資料庫
                    $sql_query = "INSERT INTO `contact_object` (objID, name) VALUES ('$new_id', '$name')";
                    mysql_query($sql_query);

                    // 提示用戶物件已新增
                    echo '<script language="JavaScript">alert("物件新增成功!");location.href="CPS_OBJ.php";</script>';
                    //echo "<script>物件新增成功！('物件新增成功!');</script>";
                    //echo "<p>物件新增成功！</p>";
                    /*echo '<script>
                            setTimeout(function() {
                                window.location.href = "CPS_OBJ.php"; // 跳回CPS_OBJ.php
                            }, 2000); // 2000ms（即2秒）
                        </script>';
                    */
                }
            }
        }
        ?>

        
        <div class="container">
            <div class="center"> 
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="name"><span style="color: black; font-weight: bold; font-size: 24px;">物件地址：</span></label><br>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>"style="width: 800px; height: 40px;"><br><br>
                    
                    <input type="submit" value="新增">
                </form>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Rent Management System 2024</p></div>
        </footer>
    </body>
</html>
