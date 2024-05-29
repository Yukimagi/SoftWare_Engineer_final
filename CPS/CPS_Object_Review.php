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
        <link href="css/star.css" rel="stylesheet" />
        <style>
        .vertical-line {
          border-left: 1px solid #808080; /* 顏色與寬度等 */
          height: 50px; /* 線的長度 */
          margin: 0 20px; /* 位置 */
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
                <a class="navbar-brand" href="CPS_Home.php">CPS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../index02.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) { //這裡的href="CPS_Publish_Artical.php"改成
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_addobj.php">新增物件</a></li>';
                        }
                        ?>
                        <!--<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>-->
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
                    <h1 class="fw-bolder">物件評價</h1>
                    
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->


                    <?php
                        //$title = $content = "";
                        // 檢查是否前一個頁面獲得objID
                        if(isset($_GET['objID'])) {
                            $objID = $_GET['objID'];
                        }

                    ?>

                    <?php
                        $select_db=@mysql_select_db("rentsystem");//選擇資料庫
                        if(!$select_db)
                        {
                            echo'<br>找不到資料庫!<br>';
                        }
                        else
                        {//查table
                            $sql_query2 = "SELECT * FROM `contact_object` WHERE objID = '$objID'";
                            $result2 = mysql_query($sql_query2);
                            while ($row2 = mysql_fetch_assoc($result2)) {
                                $name = $row2['name'];  //物件名稱(地址)

                                // 輸出物件名
                                echo '<div class="card mb-4">';
                                echo '<div class="card-body">';
                                echo '<h2 class="card-title h4">' . $name . '</h2>';
                                
                                echo'<ul class="list-unstyled mb-0">';

                                if (!($identity === "SYS" || $identity === "L" || $identity === "訪客")) {
                                
                                    // 檢查是否已經評價過
                                    $check_query = "SELECT * FROM `user_obj` WHERE `uid` = '$uid' AND `objID` = '$objID'";
                                    $check_result = mysql_query($check_query);
                                    $existing_row = mysql_fetch_assoc($check_result);
                                
                                    if ($existing_row) {
                                        // 如果已經評價過，顯示提示訊息並填入已有評價
                                        $existing_rating = $existing_row['score'];
                                        $existing_content = $existing_row['msg'];
                                
                                        //echo "<script>alert('您已評價過這個物件!');</script>";
                                
                                        echo '<div class="container">';
                                        echo '<div class="center">';
                                        echo '<form method="post" action="">'; // 将 action 设置为空字符串
                                        echo '<input type="hidden" name="objID" value="' . $objID . '">';
                                
                                        // 星級評分系統
                                        echo '<label for="rating"><span style="color: black; font-weight: bold; font-size: 24px;">修改您的評價:</span></label><br>';
                                        echo '<div class="rating">';
                                        
                                        for ($i = 5; $i >= 1; $i--) {
                                            $checked = ($i == $existing_rating) ? 'checked' : '';
                                            echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '" ' . $checked . '>';
                                            echo '<label for="star' . $i . '"></label>';
                                        }
                                        echo '</div><br>';
                                
                                        // 文字輸入框
                                        echo '<textarea id="content" name="content" style="width: 1200px; height: 50px;">' . $existing_content . '</textarea><br><br>';
                                
                                        echo '<input type="submit" name="action" value="修改">';
                                        echo '<input type="submit" name="action" value="刪除">';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    } else {
                                        // 显示空的评价表单
                                        echo '<div class="container">';
                                        echo '<div class="center">';
                                        echo '<form method="post" action="">'; // 将 action 设置为空字符串
                                        echo '<input type="hidden" name="objID" value="' . $objID . '">';
                                
                                        // 星級評分系統
                                        echo '<label for="rating"><span style="color: black; font-weight: bold; font-size: 24px;">留下您的評價:</span></label><br>';
                                        echo '<div class="rating">';
                                        
                                        for ($i = 5; $i >= 1; $i--) {
                                            echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '">';
                                            echo '<label for="star' . $i . '"></label>';
                                        }
                                        echo '</div><br>';
                                
                                        // 文字輸入框
                                        echo '<textarea id="content" name="content" style="width: 1200px; height: 50px;"></textarea><br><br>';
                                
                                        echo '<input type="submit" name="action" value="送出">';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                                
                                // 表單提交後處理
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $rating = $_POST['rating'];
                                    $content = $_POST['content'];
                                    $objID = $_POST['objID']; // 从表单中获取 objID
                                    $action = $_POST['action']; // 获取操作类型（送出、修改、刪除）
                                
                                    // 再次檢查是否已經評價過
                                    $check_query = "SELECT * FROM `user_obj` WHERE `uid` = '$uid' AND `objID` = '$objID'";
                                    $check_result = mysql_query($check_query);
                                    $existing_row = mysql_fetch_assoc($check_result);
                                
                                    if ($existing_row) {
                                        if ($action == '修改') {
                                            // 修改现有评价
                                            $update_query = "UPDATE `user_obj` SET `score` = '$rating', `msg` = '$content' WHERE `uid` = '$uid' AND `objID` = '$objID'";
                                            mysql_query($update_query);
                                            echo '<script language="JavaScript">alert("評論修改成功!");location.href="CPS_OBJ.php";</script>';
                                        } elseif ($action == '刪除') {
                                            // 删除现有评价
                                            $delete_query = "DELETE FROM `user_obj` WHERE `uid` = '$uid' AND `objID` = '$objID'";
                                            mysql_query($delete_query);
                                            echo '<script language="JavaScript">alert("評論刪除成功!");location.href="CPS_OBJ.php";</script>';
                                        }
                                    } else {
                                        if ($action == '送出') {
                                            // 插入新评价
                                            $insert_query = "INSERT INTO `user_obj` (uid, objID, score, msg) VALUES ('$uid', '$objID', '$rating', '$content')";
                                            mysql_query($insert_query);
                                            echo '<script language="JavaScript">alert("評論新增成功!");location.href="CPS_OBJ.php";</script>';
                                        }
                                    }
                                }
                                
                                //印出所有在該物件裡面的評價
                                $sql_query4 = "SELECT * FROM `user_obj` WHERE objID = '$objID'";
                                $result4 = mysql_query($sql_query4);
                                while ($row4 = mysql_fetch_assoc($result4)) {
                                    $uid = $row4['uid'];
                                    $score = $row4['score'];
                                    $msg = $row4['msg'];

                                    // 輸出文章
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<p class="card-text"><strong>' . $uid . '</strong>:</p>';
                                    
                                    // 顯示星等
                                    echo '<div class="star-rating" style="margin-left: 20px;">';
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $score) {
                                            echo '<span class="star" style="color: gold;">&#9733;</span>'; // 填滿的星星
                                        } else {
                                            echo '<span class="star" style="color: lightgray;">&#9734;</span>'; // 空的星星
                                        }
                                    }
                                    echo '</div>';
                                    
                                    echo '<p class="card-text" style="margin-left: 20px;">' . $msg . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                    
                </div>

            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Rent Management System 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>