<script src="js/scripts.js"></script>
<?php
include("connection.php");
        
// 檢查是否有傳遞用戶ID
if (isset($_POST['id'])) {
    $apply_id = $_POST['id'];

    $apply_name = $_POST['name'];
    $apply_phone = $_POST['phone'];
    $apply_reason = $_POST['reason'];

    $sql_query = "INSERT INTO account_applications(`id`,`name`,`phone`,`reason`) VALUES";
    $sql_query .= "(:id, :name, :phone, :reason)";
    $result = $conn->prepare($sql_query);
    $result->bindParam(":id", $apply_id);
    $result->bindParam(":name", $apply_name);
    $result->bindParam(":phone", $apply_phone);
    $result->bindParam(":reason", $apply_reason);

    if ($result->execute()) {
        echo '<script>registermsg()</script>';
    } else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>