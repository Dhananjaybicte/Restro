<?php
include 'db.php';

$sql = "SELECT DISTINCT category FROM stock";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}
echo json_encode($categories);
?>
