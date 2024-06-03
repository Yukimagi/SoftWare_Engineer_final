<script src="../js/scripts.js"></script>
<?php
include("connection.php");

// 檢查是否有傳遞用戶ID
if (isset($_POST['id'])) {
    $apply_id = $_POST['id'];
    $status = $_POST['approval'];
    if ($status == "通過"){
        $status = "approved";
    }elseif ($status == "駁回"){
        $status = "rejected";
    }

    $sql_query = "UPDATE account_applications SET 
        account_applications.status = :status
        WHERE account_applications.id = :id";
    $result = $conn->prepare($sql_query);
    $result->bindParam(":status", $status);
    $result->bindParam(":id", $apply_id);

    if ($result->execute()) {
        if ($status == "approved"){
            echo '<script>applicationsgranted()</script>';
        }elseif ($status == "rejected"){
            echo '<script>applicationsdenied()</script>';
        }
    } else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>