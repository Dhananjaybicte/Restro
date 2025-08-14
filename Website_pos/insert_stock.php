<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "Website_pos";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File upload handling
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$category = $_POST['category'];
$name = $_POST['name'];
$price = $_POST['price'];

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO stock (category, name, price, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $category, $name, $price, $targetFile);

        if ($stmt->execute()) {
            echo "Stock inserted successfully!";
        } else {
            echo "Database insertion failed.";
        }

        $stmt->close();
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "Image is required.";
}

$conn->close();
?>
