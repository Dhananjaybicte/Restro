<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "pos";


$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$category = $_POST['category'];
$name = $_POST['name'];
$price = $_POST['price'];

// Handle image upload
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$imageName = basename($_FILES["image"]["name"]);
$targetFile = $targetDir . time() . "_" . $imageName;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    $stmt = $conn->prepare("INSERT INTO stock (category, name, price, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $category, $name, $price, $targetFile);

    if ($stmt->execute()) {
        echo "Stock added successfully!";
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Failed to upload image.";
}

$conn->close();
?>
