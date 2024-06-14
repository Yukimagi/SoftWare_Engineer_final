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
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== 1) {
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
                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_Publish_Artical.php">刊登文章</a></li>';
                        }
                        ?>
                        <!--<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>-->
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../logoutprocess.php">使用者登出</a></li>';
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
                    <h1 class="fw-bolder">文章回覆</h1>
                    
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->


                    <?php
                        //$title = $content = "";
                        // 檢查是否前一個頁面獲得articleID
                        if(isset($_GET['articleID'])) {
                            $articleID = $_GET['articleID'];
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

                                
                                $sql_query2 = "SELECT * FROM `contact article` WHERE articleID = '$articleID'";
                                $result2 = mysql_query($sql_query2);
                                while ($row2 = mysql_fetch_assoc($result2)) {
                                    $articleIname = $row2['articleIname'];
                                    $articleIcontent = $row2['articleIcontent'];
                                    $lovenum = $row2['lovenum'];
                                    $keepnum = $row2['keepnum'];

                                    // 輸出文章
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title h4">' . $articleIname . '</h2>';
                                    echo '<p class="card-text">' . $articleIcontent . '</p>';
                                    echo'<ul class="list-unstyled mb-0">';
                                    echo '<li><span>Likes: ' . $lovenum . '</span>';
                                    //echo '<a class="btn btn-primary btn-sm custom-btn" style="margin-left: 19px;" href="CPS_dataProcess/update_love.php?articleID=' . $articleID . '">按讚</a></li>';
                                    if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                                    echo '<button class="btn btn-primary btn-sm custom-btn"style="margin-left: 19px;" onclick="loveArticle(\'' . $articleID . '\')">按讚</button></li>';
                                    }
                                    //echo '<span>Likes: ' . $lovenum . '</span>';
                                    //echo '';
                                    echo '<li><span>Keeps: ' . $keepnum . '</span>';
                                    if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                                    echo '<button class="btn btn-primary btn-sm custom-btn" style="margin-left: 10px;" onclick="keepArticle(\'' . $uid . '\', \'' . $articleID . '\')">收藏</button></li>';
                                    }
                                    //$content="";
                                    echo'</ul>';
                                    echo'<ul class="list-unstyled mb-0">';
                                    //echo'<li><a class="btn btn-primary btn-sm custom-btn" href="CPS_Artical_Modify.php?articleID=' . $articleID . '">修改文章</a>';
                                    //echo '<button class="btn btn-primary btn-sm custom-btn" style="margin-left: 10px;" onclick="DeleteArticle(\'' . $uid . '\', \'' . $articleID . '\')">刪除</button></li>';
                                    if(!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                                    echo'<div class="container">';
                                        echo'<div class="center">'; 
                                            echo'<form method="post" action="CPS_Artical_Response2.php">';
                                                echo '<input type="hidden" name="articleID" value="' . $articleID . '">';
                                                echo'<label for="content"><span style="color: black; font-weight: bold; font-size: 24px;">回覆:</span></label><br>';
                                                echo'<textarea id="content" name="content" style="width: 1200px; height: 50px;"></textarea><br><br>';
                                                
                                                echo'<input type="submit" value="送出">';
                                            echo'</form>';
                                        echo'</div>';
                                    echo'</div>';
                                    echo'</ul>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                }
                                $num=1;
                                $sql_query3 = "SELECT * FROM `article_msg` WHERE articleID = '$articleID'";
                                $result3 = mysql_query($sql_query3);
                                while ($row3 = mysql_fetch_assoc($result3)) {
                                    $msg = $row3['msg'];


                                    // 輸出文章
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<p class="card-text">回覆' . $num . ':</p>';
                                    echo '<p class="card-text">' . $msg . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                    $num++;
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
