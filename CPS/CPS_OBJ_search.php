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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_Communicate.php">交流平台</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_Home.php">個人</a></li>';
                        }
                        ?>
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_addobj.php">新增物件</a></li>';
                        }
                        ?>
                        <!--<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>-->
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../logoutprocess.php
">使用者登出</a></li>';
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
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="assets/review_warn.png" alt="..." /></a>
                        <div class="card-body">

                        </div>
                    </div>
                    <?php
                        // Select the database
                        $select_db = @mysql_select_db("rentsystem");
                        if (!$select_db) {
                            echo '<br>找不到資料庫!<br>';
                            exit();
                        }

                        // Check if searchTerm is received
                        if (!isset($_POST['searchTerm'])) {
                            header("Location: CPS_OBJ.php");
                            exit();
                        } else {
                            // Get the search term
                            $searchTerm = $_POST['searchTerm'];

                            // Prepare the SQL query
                            $sql_query = "SELECT contact_object.objID, contact_object.name, ROUND(AVG(user_obj.score), 1) AS avg_score 
                                        FROM contact_object 
                                        LEFT JOIN user_obj ON contact_object.objID = user_obj.objID 
                                        WHERE contact_object.name LIKE '%$searchTerm%' 
                                        GROUP BY contact_object.objID, contact_object.name";

                            $result = mysql_query($sql_query);

                            // Output the matched articles
                            while ($row = mysql_fetch_assoc($result)) {
                                $objID = $row['objID'];
                                $name = $row['name'];
                                $avg_score = $row['avg_score'];

                                // Output the data
                                echo '<div class="card mb-4">';
                                echo '<div class="card-body">';
                                echo '<h2 class="card-title h4">物件名稱: ' . $name . '</h2>';
                                echo '<p class="card-text">物件 ID: ' . $objID . '</p>';
                                echo '<p class="card-text">平均星等: ' . $avg_score . '</p>';
                                echo '</div>';
                                echo '</div>';
                                
                                echo '<ul class="list-unstyled mb-0">';
                                echo '<li><a class="btn btn-primary btn-sm custom-btn" href="CPS_Object_Review.php?objID=' . $objID . '">Read more →</a></li>';
                                echo '</ul>';
                                echo '</br>';
                            }
                        }
                    ?>

                    <!-- 記得引入函數-->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        $('#search-form').submit(function(event) {
                            event.preventDefault();
                            var searchTerm = $('#search-term').val().trim();

                            if (searchTerm === '') {
                                // If searchTerm is empty, redirect to CPS_OBJ.php
                                window.location.href = 'CPS_OBJ.php';
                            } else {
                                // Send the search term via POST
                                $.post('CPS_OBJ_search.php', { searchTerm: searchTerm }, function(response) {
                                    // Process the returned response
                                    $('body').html(response); // Replace the body content with the response
                                });
                            }
                        });
                    });
                    </script>

                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    
                    <div class="card mb-4">
                        <div class="card-header">找物件</div>
                        <div class="card-body">
                            <form id="search-form" method="post" action="CPS_OBJ_search.php">
                                <div class="input-group">
                                    <input class="form-control" id="search-term" name="searchTerm" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                    <button class="btn btn-primary" type="submit">Go!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Sorting widget-->
                    <!--
                    <div class="card mb-4">
                        <div class="card-header">評價排序</div>
                        <div class="card-body">
                            <form id="sort-form" method="get" action="CPS_OBJ.php">
                                <select class="form-select" id="sort-by" name="sortOption">
                                    <option value="objID">按物件代號</option>
                                    <option value="maxScore">最高分</option>
                                    <option value="minScore">最低分</option>
                                </select>
                                <button class="btn btn-primary mt-2" type="submit">排序</button>
                            </form>
                        </div>
                    </div>
                    -->
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
