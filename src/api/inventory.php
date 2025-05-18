<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT p.prod_id, p.product_name, p.desc, p.unit_price, p.image_code, i.quantity 
            FROM productInfo p 
            LEFT JOIN inventory i ON p.prod_id = i.prod_id 
            ORDER BY p.prod_id";
    
    $result = $conn->query($sql);
    $products = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($products);
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (!isset($data['product_name']) || !isset($data['description']) || 
        !isset($data['unit_price']) || !isset($data['image_code']) || !isset($data['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $conn->begin_transaction();
    
    try {
        $stmt1 = $conn->prepare("INSERT INTO productInfo (product_name, `desc`, unit_price, image_code) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("ssii", $data['product_name'], $data['description'], $data['unit_price'], $data['image_code']);
        
        if (!$stmt1->execute()) {
            throw new Exception("Failed to add product information");
        }
        
        $productId = $conn->insert_id;
        
        $stmt2 = $conn->prepare("INSERT INTO inventory (prod_id, quantity) VALUES (?, ?)");
        $stmt2->bind_param("ii", $productId, $data['quantity']);
        
        if (!$stmt2->execute()) {
            throw new Exception("Failed to add inventory information");
        }
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Product added successfully', 'prod_id' => $productId]);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$conn->close();
?>