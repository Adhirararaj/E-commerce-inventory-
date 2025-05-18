<?php
include '../db_config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT p.*, i.quantity FROM productInfo p 
        LEFT JOIN inventory i ON p.prod_id = i.prod_id";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE p.product_name LIKE '%$search%' OR p.desc LIKE '%$search%'";
}

$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imagePath = 'images/' . $row['image_code'] . '.webp';
        if (!file_exists('../' . $imagePath)) {
            $imagePath = 'images/default.webp';
        }
        $row['image_path'] = $imagePath;
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);
$conn->close();
?>