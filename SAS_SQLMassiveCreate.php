<script src="js/scripts.js"></script>
<?php
include("connection.php");
        
// 檢查是否有傳遞用戶ID
if (isset($_POST['identity'])) {
    $user_identity = $_POST['identity'];
    $count = $_POST['input_number'];

    //先新增至 user_profile
    $sql_query = "SELECT MAX(user_profile.uid) as now FROM user_profile";
    $result = $conn->query($sql_query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $currentUid = $row['now'];
    $numberPart = (int)substr($currentUid, 1); // 提取數字部分，並轉換為整數

    while ($count > 0) {
        $numberPart = $numberPart + 1; // 增加 1
        $new_Uid = "U" . str_pad($numberPart, 5, "0", STR_PAD_LEFT); // 補齊零填充並連接回 "U" 字母

        $sql_query = "INSERT INTO user_profile(`uid`,`account`,`password`,`identity`) VALUES";
        $sql_query .= "(:uid, :account, :password, :identity)";
        $result = $conn->prepare($sql_query);
        $result->bindParam(":uid", $new_Uid);
        $result->bindParam(":account", $new_Uid);
        $result->bindParam(":password", $new_Uid);
        $result->bindParam(":identity", $user_identity);
        if ($result->execute()) {
        } else {
            echo '<script>warning4()</script>';
        }
        $count--;
    }
    echo '<script>createmsg()</script>';
    exit;
}
?>