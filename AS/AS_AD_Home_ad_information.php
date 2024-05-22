<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Detail Page</h1>
        <?php
        include("connection.php");

        if (isset($_GET["r_place"])) {
            $rid = $_GET["r_place"];

            $sql = "SELECT * FROM ad WHERE r_place = :r_place";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":rid", $rid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo "<h2>Details for RID: " . htmlspecialchars($rid) . "</h2>";
                echo "<p>Place: " . htmlspecialchars($row["r_place"]) . "</p>";
                echo "<p>Format: " . htmlspecialchars($row["r_format"]) . "</p>";
                echo "<p>Money: " . htmlspecialchars($row["r_money"]) . "</p>";
                echo "<p>Deposit: " . htmlspecialchars($row["r_deposit"]) . "</p>";
                echo "<p>Utility Bill: " . htmlspecialchars($row["r_utilitybill"]) . "</p>";
                echo "<p>Content: " . htmlspecialchars($row["r_else"]) . "</p>";
                if (!empty($row["r_post"])) {
                    echo '<img src="data:image/jpeg;base64,' . $row["r_post"] . '" style="max-width:400px; max-height:400px;"/><br>';
                }
                if (!empty($row["r_photo1"])) {
                    echo '<img src="data:image/jpeg;base64,' . $row["r_photo1"] . '" style="max-width:400px; max-height:400px;"/><br>';
                }
                if (!empty($row["r_photo2"])) {
                    echo '<img src="data:image/jpeg;base64,' . $row["r_photo2"] . '" style="max-width:400px; max-height:400px;"/><br>';
                }
                if (!empty($row["r_photo3"])) {
                    echo '<img src="data:image/jpeg;base64,' . $row["r_photo3"] . '" style="max-width:400px; max-height:400px;"/><br>';
                }
                if (!empty($row["r_photo4"])) {
                    echo '<img src="data:image/jpeg;base64,' . $row["r_photo4"] . '" style="max-width:400px; max-height:400px;"/><br>';
                }
            } else {
                echo "No details found for RID: " . htmlspecialchars($rid);
            }
        } else {
            echo "No RID specified.";
        }
        $conn = null;
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
