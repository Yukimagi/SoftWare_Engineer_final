<script src="../js/scripts.js"></script>
<?php
include("connection.php");
        
// 檢查是否有傳遞用戶ID
if (isset($_GET['ap'])) {
    $id = $_GET['ap'];

    $sql_query = "select * from account_applications where id='" . $id . "'";
    $result = $conn->query($sql_query);
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if ($row['status'] == "pending") {
            echo '<script>result_pending()</script>';
        } else if ($row['status'] == "approved") {
            echo '<script>result_approved()</script>';
        } else if ($row['status'] == "rejected") {
            echo '<script>result_rejected()</script>';
        }
    }else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>