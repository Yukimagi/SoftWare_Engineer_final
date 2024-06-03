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
                <a class="navbar-brand" href="IS_teacher_records.php">IS</a>
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

        
        // 獲取學年
        $sql_school_year = "SELECT DISTINCT school_year FROM interview_record where s_uid='$uid'";
        $stmt_school_year = $conn->query($sql_school_year);
        $school_years = $stmt_school_year->fetchAll(PDO::FETCH_ASSOC);

        // 準備獲取學期的 SQL 查詢
        $sql_semester = "SELECT DISTINCT semester FROM interview_record WHERE interview_record.school_year = :school_year and s_uid='$uid'";
        $stmt_semester = $conn->prepare($sql_semester);

        // 初始化用來保存學期的數組
        $all_semesters = [];

        foreach ($school_years as $year) {
            // 綁定學年參數並執行查詢
            $stmt_semester->bindParam(':school_year', $year['school_year']);
            $stmt_semester->execute();
            
            // 獲取當前學年的學期
            $semesters = $stmt_semester->fetchAll(PDO::FETCH_ASSOC);
            
            // 添加結果到 all_semesters 數組
            $all_semesters[$year['school_year']] = $semesters;
        }

        ?>
        <?php       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_identifier = $_POST["form_identifier"];
            if ($form_identifier == "form1") {
                $selected_school_year = $_POST['school_year'];
                $selected_semester = $_POST['semester'];
                $sql_records = "SELECT interview_record.* , basicinfo.sid FROM interview_record join basicinfo WHERE interview_record.s_uid=basicinfo.uid and interview_record.s_uid = :sid
                    and interview_record.school_year = :school_year and interview_record.semester = :semester";
                // echo($sql_records);
                $stmt_records = $conn->prepare($sql_records);
                $stmt_records->bindParam(':sid', $uid);
                $stmt_records->bindParam(':school_year', $selected_school_year);
                $stmt_records->bindParam(':semester', $selected_semester);
                $stmt_records->execute();
                $records = $stmt_records->fetch(PDO::FETCH_ASSOC);
                
                $name = $records['sid'];
                $s_uid = $records['s_uid'];
                $school_year = $selected_school_year;
                $semester = $selected_semester;
                $landlord_name = $records['landlord_name'];
                $landlord_phone = $records['landlord_phone'];
                $address = $records['address'];
                $housing_type = $records['housing_type'];
                $room_type = $records['room_type'];
                $money = $records['money'];
                $deposit = $records['deposit'];
                $q0 = $records['q0'];
                $q1 = $records['q1'];
                $q2 = $records['q2'];
                $q3 = $records['q3'];
                $q4 = $records['q4'];
                $q5 = $records['q5'];
                $q6 = $records['q6'];
                $q7 = $records['q7'];
                $q8 = $records['q8'];
                $q9 = $records['q9'];
                $q10 = $records['q10'];
                $q11 = $records['q11'];
                $q12 = $records['q12'];
                $q13 = $records['q13'];

            }
        }        
        ?>
        
        <div class="container">
            <div class="center">
                
                <form id="open_record" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="form_identifier" value="form1">

                        <label for="select_school_year"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學年：</span></label>
                        <select id="select_school_year" name="school_year" required>
                            <option value="" disabled selected>選擇學年</option>
                            <?php foreach ($school_years as $row1) { ?>
                                <option value="<?php echo $row1['school_year']; ?>"><?php echo $row1['school_year']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="select_semester"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學期：</span></label>
                        <select id="select_semester" name="semester" required>
                            <option value="" disabled selected>選擇學期</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>

                        <button type="submit" class="send-button">送出</button>
                </form>
                <script>
                    // JavaScript to dynamically update the semester dropdown
                    const allSemesters = <?php echo json_encode($all_semesters); ?>;

                    document.getElementById('select_school_year').addEventListener('change', function() {
                        const schoolYear = this.value;
                        const semesterDropdown = document.getElementById('select_semester');

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

            <?php if (isset($records)) { ?>
                <form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="form_identifier" value="form2">
                    <p></p>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學年：<?php echo($school_year);?></span></label>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學期：<?php echo($semester);?></span></label>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學生：<?php echo($name);?></span></label>
                    <p></p>
                    <p></p>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">校外賃居資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="landlord_name"><span style="color: black; font-weight: bold;">房東姓名：</span></label>
                        <input type="text" id="landlord_name" name="landlord_name" value="<?php echo $landlord_name; ?>" class="underline-input" readonly>
                        
                        <label for="landlord_phone"><span style="color: black; font-weight: bold;">房東電話：</span></label>
                        <input type="text" id="landlord_phone" name="landlord_phone" value="<?php echo $landlord_phone; ?>" class="underline-input" readonly>

                        <label for="address"><span style="color: black; font-weight: bold;">租賃地址：</span></label>
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>" class="underline-input" style="width: 400px;" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租屋型態：</span>
                        </label>

                        <input type="radio" id="detached" name="housing_type" value="獨棟透天" <?php if($housing_type == "獨棟透天") echo "checked"; ?> disabled>
                        <label for="detached" style="margin-right: 10px; <?php if($housing_type == "獨棟透天") echo "color: blue;"; ?>">獨棟透天</label>

                        <input type="radio" id="apartment" name="housing_type" value="公寓(五樓以下)" <?php if($housing_type == "公寓(五樓以下)") echo "checked"; ?> disabled>
                        <label for="apartment" style="margin-right: 10px; <?php if($housing_type == "公寓(五樓以下)") echo "color: blue;"; ?>">公寓(五樓以下)</label>

                        <input type="radio" id="highrise" name="housing_type" value="大樓(六樓以上)" <?php if($housing_type == "大樓(六樓以上)") echo "checked"; ?> disabled>
                        <label for="highrise" style="margin-right: 10px; <?php if($housing_type == "大樓(六樓以上)") echo "color: blue;"; ?>">大樓(六樓以上)</label>

                        <input type="radio" id="dorm" name="housing_type" value="大型學舍(為學生建設的宿舍)" <?php if($housing_type == "大型學舍(為學生建設的宿舍)") echo "checked"; ?> disabled>
                        <label for="dorm" style="margin-right: 10px; <?php if($housing_type == "大型學舍(為學生建設的宿舍)") echo "color: blue;"; ?>">大型學舍(為學生建設的宿舍)</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="room_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間類型：</span>
                        </label>

                        <input type="radio" id="suite" name="room_type" value="套房" <?php if($housing_type == "套房") echo "checked"; ?> disabled>
                        <label for="suite" style="margin-right: 10px; <?php if($room_type == "套房") echo "color: blue;"; ?>">套房</label>

                        <input type="radio" id="elegant_house" name="room_type" value="雅房" <?php if($housing_type == "雅房") echo "checked"; ?> disabled>
                        <label for="elegant_house" style="margin-right: 10px; <?php if($room_type == "雅房") echo "color: blue;"; ?>">雅房</label><br><br>
                    </div>

                    <div class="form-row">
                        <label for="rent"><span style="color: black; font-weight: bold;">每月租金：</span></label>
                        <input type="text" id="rent" name="rent" value="<?php echo $money; ?>" class="underline-input" readonly>
                        
                        <label for="deposit"><span style="color: black; font-weight: bold;">押金：</span></label>
                        <input type="text" id="deposit" name="deposit" value="<?php echo $deposit; ?>" class="underline-input" readonly>

                        <label for="Q0" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否推薦其他同學租賃？</span>
                        </label>

                        <input type="radio" id="yes0" name="Q0" value="是" <?php if($q0 == "是") echo "checked"; ?> disabled>
                        <label for="yes0" style="margin-right: 10px; <?php if($q0 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no0" name="Q0" value="否" <?php if($q1 == "否") echo "checked"; ?> disabled>
                        <label for="no0" style="margin-right: 10px; <?php if($q0 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <p></p>
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">賃居安全自主管理檢視資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="Q1" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所消防設備是否符合標準：</span>
                        </label>

                        <input type="radio" id="yes1" name="Q1" value="是" <?php if($q1 == "是") echo "checked"; ?> disabled>
                        <label for="yes1" style="margin-right: 10px; <?php if($q1 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no1" name="Q1" value="否" <?php if($q1 == "否") echo "checked"; ?> disabled>
                        <label for="no1" style="margin-right: 10px; <?php if($q1 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有火災警報器：</span>
                        </label>

                        <input type="radio" id="yes2" name="Q2" value="是" <?php if($q2 == "是") echo "checked"; ?> disabled>
                        <label for="yes2" style="margin-right: 10px; <?php if($q2 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no2" name="Q2" value="否" <?php if($q2 == "否") echo "checked"; ?> disabled>
                        <label for="no2" style="margin-right: 10px; <?php if($q2 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有消防栓、滅火器：</span>
                        </label>

                        <input type="radio" id="yes3" name="Q3" value="是" <?php if($q3 == "是") echo "checked"; ?> disabled>
                        <label for="yes3" style="margin-right: 10px; <?php if($q3 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no3" name="Q3" value="否" <?php if($q3 == "否") echo "checked"; ?> disabled>
                        <label for="no3" style="margin-right: 10px; <?php if($q3 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有防火避難方向標示、逃生設備：</span>
                        </label>

                        <input type="radio" id="yes4" name="Q4" value="是" <?php if($q4 == "是") echo "checked"; ?> disabled>
                        <label for="yes4" style="margin-right: 10px; <?php if($q4 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no4" name="Q4" value="否" <?php if($q4 == "否") echo "checked"; ?> disabled>
                        <label for="no4" style="margin-right: 10px; <?php if($q4 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房東或租賃處所是否有投保火災保險：</span>
                        </label>

                        <input type="radio" id="yes5" name="Q5" value="是" <?php if($q5 == "是") echo "checked"; ?> disabled>
                        <label for="yes5" style="margin-right: 10px; <?php if($q5 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no5" name="Q5" value="否" <?php if($q5 == "否") echo "checked"; ?> disabled>
                        <label for="no5" style="margin-right: 10px; <?php if($q5 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">電線走火是否為套管走火或有整齊固定：</span>
                        </label>

                        <input type="radio" id="yes6" name="Q6" value="是" <?php if($q6 == "是") echo "checked"; ?> disabled>
                        <label for="yes6" style="margin-right: 10px; <?php if($q6 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no6" name="Q6" value="否" <?php if($q6 == "否") echo "checked"; ?> disabled>
                        <label for="no6" style="margin-right: 10px; <?php if($q6 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">大樓出入口或主要出口是否有鐵捲門或鐵柵門：</span>
                        </label>

                        <input type="radio" id="yes7" name="Q7" value="是" <?php if($q7 == "是") echo "checked"; ?> disabled>
                        <label for="yes7" style="margin-right: 10px; <?php if($q7 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no7" name="Q7" value="否" <?php if($q7 == "否") echo "checked"; ?> disabled>
                        <label for="no7" style="margin-right: 10px; <?php if($q7 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所是否有公安檢查合格或其他相關證明：</span>
                        </label>

                        <input type="radio" id="yes8" name="Q8" value="是" <?php if($q8 == "是") echo "checked"; ?> disabled>
                        <label for="yes8" style="margin-right: 10px; <?php if($q8 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no8" name="Q8" value="否" <?php if($q8 == "否") echo "checked"; ?> disabled>
                        <label for="no8" style="margin-right: 10px; <?php if($q8 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否有對外窗戶或通風口：</span>
                        </label>

                        <input type="radio" id="yes9" name="Q9" value="是" <?php if($q9 == "是") echo "checked"; ?> disabled>
                        <label for="yes9" style="margin-right: 10px; <?php if($q9 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no9" name="Q9" value="否" <?php if($q9 == "否") echo "checked"; ?> disabled>
                        <label for="no9" style="margin-right: 10px; <?php if($q9 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有廚房、瓦斯爐具：</span>
                        </label>

                        <input type="radio" id="yes10" name="Q10" value="是" <?php if($q10 == "是") echo "checked"; ?> disabled>
                        <label for="yes10" style="margin-right: 10px; <?php if($q10 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no10" name="Q10" value="否" <?php if($q10 == "否") echo "checked"; ?> disabled>
                        <label for="no10" style="margin-right: 10px; <?php if($q10 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間是否設置簡易型瓦斯警報器：</span>
                        </label>

                        <input type="radio" id="yes11" name="Q11" value="是" <?php if($q11 == "是") echo "checked"; ?> disabled>
                        <label for="yes11" style="margin-right: 10px; <?php if($q11 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no11" name="Q11" value="否" <?php if($q11 == "否") echo "checked"; ?> disabled>
                        <label for="no11" style="margin-right: 10px; <?php if($q11 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有配置飲水機：</span>
                        </label>

                        <input type="radio" id="yes12" name="Q12" value="是" <?php if($q12 == "是") echo "checked"; ?> disabled>
                        <label for="yes12" style="margin-right: 10px; <?php if($q12 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no12" name="Q12" value="否" <?php if($q12 == "否") echo "checked"; ?> disabled>
                        <label for="no12" style="margin-right: 10px; <?php if($q12 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所附近生活機能良好：</span>
                        </label>

                        <input type="radio" id="yes13" name="Q13" value="是" <?php if($q13 == "是") echo "checked"; ?> disabled>
                        <label for="yes13" style="margin-right: 10px; <?php if($q13 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no13" name="Q13" value="否" <?php if($q13 == "否") echo "checked"; ?> disabled>
                        <label for="no13" style="margin-right: 10px; <?php if($q13 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                </form>
            </div>
            <?php }?>
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