<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>IS</title>
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
            if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1)) {
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
                $result = $conn->query($sql_query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $name = $row["name"];
            }
        ?>
        <!-- 上面的標籤-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="IS_sys_search_records.php">IS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>

                        <?php
                        if(($identity === "S")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_information.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_student_search_record.php">查詢紀錄</a></li>';
                        }
                        else if($identity === "T"){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_information.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_teacher_search_record.php">查詢紀錄</a></li>';
                        }
                        else if($identity === "SYS"){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_sys_search_record.php">查詢紀錄</a></li>';
                        }
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../logoutprocess.php?logged_in=false">使用者登出</a></li>';
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
        <!-- 大標題-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">訪談紀錄表</h1>
                    <!-- <p class="lead mb-0">歡迎使用!</p> -->
                </div>
            </div>
        </header>
        <!-- Page content-->
        <?php

        // Fetch all school years for the dropdown
        $sql_school_year = "SELECT DISTINCT school_year FROM interview_record JOIN basicinfo ON basicinfo.uid = interview_record.s_uid";
        $stmt_school_year = $conn->query($sql_school_year);
        $school_years = $stmt_school_year->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the SQL query for fetching distinct semesters
        $sql_semester = "SELECT DISTINCT semester FROM interview_record JOIN basicinfo ON basicinfo.uid = interview_record.s_uid WHERE interview_record.school_year = :school_year";
        $stmt_semester = $conn->prepare($sql_semester);

        // Initialize an array to hold semesters for each school year
        $all_semesters = [];

        foreach ($school_years as $year) {
            // Bind the school year parameter and execute the query
            $stmt_semester->bindParam(':school_year', $year['school_year']);
            $stmt_semester->execute();

            // Fetch semesters for the current school year
            $semesters = $stmt_semester->fetchAll(PDO::FETCH_ASSOC);

            // Add the result to the all_semesters array
            $all_semesters[$year['school_year']] = $semesters;
        }

        // Initialize variables for selected values
        $selected_school_year = isset($_POST['school_year']) ? $_POST['school_year'] : '';
        $selected_semester = isset($_POST['semester']) ? $_POST['semester'] : '';

        // Initialize an empty array for students
        $sids = [];

        // If both school year and semester are selected, fetch students
        if ($selected_school_year && $selected_semester) {
            $sql_sid = "SELECT DISTINCT basicinfo.sid FROM interview_record 
                        JOIN basicinfo ON basicinfo.uid = interview_record.s_uid 
                        WHERE interview_record.school_year = :school_year 
                        AND interview_record.semester = :semester";
            $stmt_sid = $conn->prepare($sql_sid);
            $stmt_sid->bindParam(':school_year', $selected_school_year);
            $stmt_sid->bindParam(':semester', $selected_semester);
            $stmt_sid->execute();
            $sids = $stmt_sid->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_identifier = $_POST["form_identifier"];
            if ($form_identifier == "form1") {
                $selected_sid = isset($_POST['s_uid']) ? $_POST['s_uid'] : '';
                $selected_school_year = isset($_POST['school_year']) ? $_POST['school_year'] : '';
                $selected_semester = isset($_POST['semester']) ? $_POST['semester'] : '';

                // Fetch students who have not filled the form
                $sql_records_unwrite = "SELECT basicinfo.sid
                                        FROM basicinfo
                                        LEFT JOIN interview_record 
                                        ON basicinfo.uid = interview_record.s_uid 
                                        AND interview_record.school_year = :school_year 
                                        AND interview_record.semester = :semester
                                        WHERE interview_record.s_uid IS NULL";
                $stmt_records_unwrite = $conn->prepare($sql_records_unwrite);
                $stmt_records_unwrite->bindParam(':school_year', $selected_school_year);
                $stmt_records_unwrite->bindParam(':semester', $selected_semester);
                $stmt_records_unwrite->execute();
                $records_unwrite = $stmt_records_unwrite->fetchAll(PDO::FETCH_ASSOC);

                // Fetch students who have filled the form
                $sql_records_write = "SELECT basicinfo.sid, interview_record.*
                                    FROM basicinfo
                                    JOIN interview_record 
                                    ON basicinfo.uid = interview_record.s_uid 
                                    WHERE interview_record.school_year = :school_year 
                                    AND interview_record.semester = :semester";
                $stmt_records_write = $conn->prepare($sql_records_write);
                $stmt_records_write->bindParam(':school_year', $selected_school_year);
                $stmt_records_write->bindParam(':semester', $selected_semester);
                $stmt_records_write->execute();
                $records_write = $stmt_records_write->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        ?>

        <div class="container">
            <div class="center">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form1">
                    <input type="hidden" name="form_identifier" value="form1">

                    <label for="school_year"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學年：</span></label>
                    <select id="school_year" name="school_year" onchange="this.form.submit()">
                        <option value="" <?php echo empty($selected_school_year) ? 'selected' : ''; ?>>選擇學年</option>
                        <?php foreach ($school_years as $row1) { ?>
                            <option value="<?php echo $row1['school_year']; ?>" <?php echo ($row1['school_year'] == $selected_school_year) ? 'selected' : ''; ?>>
                                <?php echo $row1['school_year']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label for="semester"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學期：</span></label>
                    <select id="semester" name="semester" onchange="this.form.submit()">
                        <option value="">選擇學期</option>
                        <?php
                        if (!empty($selected_school_year)) {
                            foreach ($all_semesters[$selected_school_year] as $semester) { ?>
                                <option value="<?php echo $semester['semester']; ?>" <?php echo ($semester['semester'] == $selected_semester) ? 'selected' : ''; ?>>
                                    <?php echo $semester['semester']; ?>
                                </option>
                            <?php }
                        }
                        ?>
                    </select>
                </form>

                <?php if (isset($records_unwrite) && $records_unwrite) { ?>
                    <div>
                        <?php foreach ($records_unwrite as $record) {
                            $s_uid = $record['uid'];
                            $sids = $record['sid'];
                            ?>
                            <a href="IS_sys_search_record.php?s_uid=<?php echo $sids; ?>">
                                <label for="s_uid"><span style="font-weight: bold; font-size: 20px;">學生：<?php echo $sids; ?></span></label>
                                <label for="has_filled_form"><span style="color: red; font-weight: bold; font-size: 20px;">未填寫</span></label>
                            </a>
                            <p></p>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if (isset($records_write) && $records_write) { ?>
                    <div>
                        <?php foreach ($records_write as $record) {
                            $s_uid = $record['s_uid'];
                            $sids = $record['sid'];
                            ?>
                            <a href="IS_sys_search_record.php?s_uid=<?php echo $sids; ?>">
                                <label for="s_uid"><span style="font-weight: bold; font-size: 20px;">學生：<?php echo $sids; ?></span></label>
                                <label for="has_filled_form"><span style="color: green; font-weight: bold; font-size: 20px;">已填寫</span></label>
                            </a>
                            <p></p>
                        <?php } ?>
                    </div>
                <?php } ?>
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