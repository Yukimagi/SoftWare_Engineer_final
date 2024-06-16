<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sids'])) {
    $sids_array = json_decode($_POST['sids'], true);

    // 設置HTTP頭
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sids_export.csv"');

    // 打開文件流
    $output = fopen('php://output', 'w');

    // 寫入沒填寫學生的學號
    fputcsv($output, ['has not written']);

    // 寫入CSV數據
    foreach ($sids_array as $sids) {
        fputcsv($output, [$sids]);
    }

    // 關閉文件流
    fclose($output);
    exit;
}
?>
