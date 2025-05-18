<?php
include '../db_config.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['items']) || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'No items in cart']);
    exit;
}

$conn->begin_transaction();
$success = true;
$message = "";

try {
    foreach ($data['items'] as $item) {
        $prodId = $item['prodId'];
        $quantity = $item['quantity'];
        
        $checkSql = "SELECT quantity FROM inventory WHERE prod_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("i", $prodId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Product #$prodId not found in inventory");
        }
        
        $inventoryRow = $result->fetch_assoc();
        if ($inventoryRow['quantity'] < $quantity) {
            throw new Exception("Not enough inventory for product #$prodId. Available: " . $inventoryRow['quantity']);
        }
        
        $newQuantity = $inventoryRow['quantity'] - $quantity;
        $updateSql = "UPDATE inventory SET quantity = ? WHERE prod_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $newQuantity, $prodId);
        
        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update inventory for product #$prodId");
        }
        
        $updateStmt->close();
        $checkStmt->close();
    }
    
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Checkout successful']);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>