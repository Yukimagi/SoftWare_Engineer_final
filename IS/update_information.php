<?php
    //連結資料庫
    include("../connection.php");
?>

<?php

try {
    
    // 確保所有必需的字段都已提交
    if (!empty($_POST['uid']) && !empty($_POST)) {
        // 獲取用户身份
        $uid = $_POST['uid'];

        // 根據身份决定要更新的數據表
        if (!empty($_POST['identity']) && $_POST['identity'] === 'S') {
            $table = "basicinfo";
            $columns = ['phone', 'email', 'HomeAddr', 'Hphone', 'Contactor', 'Cphone'];
        } else if (!empty($_POST['identity']) && $_POST['identity'] === 'T') {
            $table = "teacher_profile";
            $columns = ['t_tel', 't_mail', 't_address', 't_officetel'];
        } else {
            throw new Exception("無效的身份");
        }

        // 更新查詢
        $set_clauses = [];
        $query_params = [];
        foreach ($columns as $column) {
            if (isset($_POST[$column])) {
                $set_clauses[] = "$column = :$column";
                $query_params[$column] = $_POST[$column];
            }
        }
        $set_clause = implode(', ', $set_clauses);
        
        //  SQL 更新查詢
        if ($table === "basicinfo") {
            $sql = "UPDATE $table SET $set_clause WHERE uid = :uid";
        } else {
            $sql = "UPDATE $table SET $set_clause WHERE t_uid = :uid";
        }

        // 準備和執行查詢
        $stmt = $conn->prepare($sql);
        $query_params['uid'] = $uid;
        $stmt->execute($query_params);

        // 檢查是否更新成功
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('資料已更新'); window.location.href='IS_personal_information.php';</script>";
        } else {
            echo "<script>alert('資料未更新，可能是因為沒有改變'); window.location.href='IS_personal_information.php';</script>";
        }
    } else {
        throw new Exception("缺少必要的表單數據");
    }
} catch (Exception $e) {
    echo "錯誤：" . $e->getMessage();
}
?>




