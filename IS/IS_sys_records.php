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
                <a class="navbar-brand" href="IS_sys_records.php">IS</a>
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
        // Assuming $conn is your database connection


        // Fetch all student s_uids for the dropdown
        // SELECT SID FROM basicinfo JOIN interview_record where basicinfo.uid='U00003' and interview_record.t_uid='U00001'
        // Step 1: Fetch distinct school years
        $sql_school_year = "SELECT DISTINCT school_year FROM record_settings ";
        $stmt_school_year = $conn->query($sql_school_year);
        $school_years = $stmt_school_year->fetchAll(PDO::FETCH_ASSOC);

        $sql_semester = "SELECT DISTINCT semester FROM record_settings WHERE record_settings.school_year = :school_year";
        $stmt_semester = $conn->prepare($sql_semester);

        // Step 3: Initialize an array to hold semesters for each school year
        $all_semesters = [];

        foreach ($school_years as $year) {
            // Step 4: Bind the school year parameter and execute the query
            $stmt_semester->bindParam(':school_year', $year['school_year']);
            $stmt_semester->execute();
            
            // Step 5: Fetch semesters for the current school year
            $semesters = $stmt_semester->fetchAll(PDO::FETCH_ASSOC);
            
            // Step 6: Add the result to the all_semesters array
            $all_semesters[$year['school_year']] = $semesters;
        }


        ?>
        <?php       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_identifier = $_POST["form_identifier"];
            if ($form_identifier == "form1") {
                $selected_student = $_POST['s_uid'];
                $selected_school_year = $_POST['school_year'];
                $selected_semester = $_POST['semester'];
                $sql_records = "SELECT distinct school_year FROM record_settings WHERE record_settings.s_uid=basicinfo.uid and basicinfo.sid = :sid
                    and record_settings.school_year = :school_year and record_settings.semester = :semester";
                
                $stmt_records = $conn->prepare($sql_records);
                $stmt_records->bindParam(':sid', $selected_student);
                $stmt_records->bindParam(':school_year', $selected_school_year);
                $stmt_records->bindParam(':semester', $selected_semester);
                $stmt_records->execute();
                $records = $stmt_records->fetch(PDO::FETCH_ASSOC);
                $sql_records = "SELECT distinct semester FROM record_settings WHERE record_settings.s_uid=basicinfo.uid and basicinfo.sid = :sid
                    and record_settings.school_year = :school_year and record_settings.semester = :semester";
                
            }
            else if ($form_identifier == "form2") {
                $sql_query = "SELECT COUNT(*) AS total_rows FROM `record_settings`";
                $result = $conn->query($sql_query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];

                if ($total_rows == 0) {
                    $new_id = "Y00000";
                } else {
                    $sql_query = "SELECT MAX(rid) AS max_id FROM `record_settings`";
                    $result = $conn->query($sql_query);
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $max_id = $row["max_id"];
                    $new_id = "Y" . str_pad(substr($max_id, 1) + 1, 5, "0", STR_PAD_LEFT);
                }

                $selected_school_year = $_POST['school_year'];
                $selected_semester = $_POST['semester'];

                $sql_check = "SELECT COUNT(*) AS count FROM `record_settings` WHERE school_year = '$selected_school_year' AND semester ='$selected_semester' ";
                // echo($sql_check);

                $stmt = $conn->prepare($sql_check);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $has_filled_form = $row['count'];

                $sql_records = "INSERT INTO record_settings VALUES(:new_id, :school_year, :semester, 0)";
                
                $stmt_records = $conn->prepare($sql_records);
                $stmt_records->bindParam(':new_id', $new_id);
                $stmt_records->bindParam(':school_year', $selected_school_year);
                $stmt_records->bindParam(':semester', $selected_semester);
                if (!$has_filled_form) {$stmt_records->execute();
                    echo "<script>alert('訪談紀錄表新增完成！'); window.location.href='IS_sys_records.php';</script>";
                }
                else {
                    echo "<script>alert('訪談紀錄表已存在！'); window.location.href='IS_sys_records.php';</script>";
                }
            }
        }      
        ?>
        <div class="container">
            <div class="center">

            <form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="form_identifier" value="form2">

                <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">新增新的訪談紀錄表</span></label><br>
                <p></p>

                <div class="form-row">
                    <label for="school_year"><span style="color: black; font-weight: bold;">學年：</span></label>
                    <input type="text" id="school_year" name="school_year" value="" class="underline-input" required>
                        
                    <label for="semester"><span style="color: black; font-weight: bold;">學期：</span></label>
                    <input type="text" id="semester" name="semester" value="" class="underline-input" required>
                    <button type="submit" class="send-button">送出</button>
                </div>
                <p></p>
                <p></p>
                <p></p>

            </form>
                
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="form_identifier" value="form1">

                <label for="school_year"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學年：</span></label>
                <select id="school_year" name="school_year" required>
                    <option value="" disabled selected>選擇學年</option>
                    <?php foreach ($school_years as $row1) { ?>
                        <option value="<?php echo $row1['school_year']; ?>"><?php echo $row1['school_year']; ?></option>
                    <?php } ?>
                </select>

                <label for="semester"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學期：</span></label>
                <select id="semester" name="semester" required>
                    <option value="" disabled selected>選擇學期</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
                
                <button type="submit" class="send-button">送出</button>
            </form>
            <script>
                // JavaScript to dynamically update the semester dropdown
                const allSemesters = <?php echo json_encode($all_semesters); ?>;

                document.getElementById('school_year').addEventListener('change', function() {
                    const schoolYear = this.value;
                    const semesterDropdown = document.getElementById('semester');

                    // Clear the current options
                    semesterDropdown.innerHTML = '<option value="" disabled selected>選擇學期</option>';

                    // Add new options based on the selected school year
                    if (allSemesters[schoolYear]) {
                        allSemesters[schoolYear].forEach(function(semester) {
                            const option = document.createElement('option');
                            option.value = semester.semester;
                            option.textContent = semester.semester;
                            semesterDropdown.appendChild(option);
                        });
                    }
                });
            </script>
            
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