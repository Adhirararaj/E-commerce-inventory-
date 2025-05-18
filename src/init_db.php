<?php
include 'db_config.php';

$products = [
    [
        'name' => 'Basic Phone',
        'desc' => 'A simple phone for basic communication needs',
        'price' => 99,
        'image' => '3',  // basicphone.webp
        'quantity' => 15
    ],
    [
        'name' => 'Flip Phone',
        'desc' => 'Classic flip phone design with modern features',
        'price' => 129,
        'image' => '4',  // flipphone.webp
        'quantity' => 8
    ],
    [
        'name' => '4G Smartphone',
        'desc' => 'Fast 4G connectivity with great battery life',
        'price' => 299,
        'image' => '1',  // 4G.webp
        'quantity' => 20
    ],
    [
        'name' => 'Smart Watch',
        'desc' => 'Track your fitness and stay connected on the go',
        'price' => 149,
        'image' => '6',  // watch.webp
        'quantity' => 12
    ],
    [
        'name' => 'Laptop Bag',
        'desc' => 'Stylish and durable bag for your laptop and accessories',
        'price' => 49,
        'image' => '2',  // bag.webp
        'quantity' => 25
    ],
    [
        'name' => 'Glance Pro PI-03',
        'desc' => 'Professional-grade device with advanced features',
        'price' => 399,
        'image' => '5',  // GlanceProPI03.webp
        'quantity' => 5
    ]
];

foreach ($products as $product) {
    $checkStmt = $conn->prepare("SELECT prod_id FROM productInfo WHERE product_name = ?");
    $checkStmt->bind_param("s", $product['name']);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo "Product {$product['name']} already exists, skipping...<br>";
        continue;
    }
    
    $stmt1 = $conn->prepare("INSERT INTO productInfo (product_name, `desc`, unit_price, image_code) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssii", $product['name'], $product['desc'], $product['price'], $product['image']);
    
    if ($stmt1->execute()) {
        $productId = $conn->insert_id;
        
        $stmt2 = $conn->prepare("INSERT INTO inventory (prod_id, quantity) VALUES (?, ?)");
        $stmt2->bind_param("ii", $productId, $product['quantity']);
        
        if ($stmt2->execute()) {
            echo "Added product: {$product['name']}<br>";
        } else {
            echo "Error adding to inventory: " . $conn->error . "<br>";
        }
    } else {
        echo "Error adding product: " . $conn->error . "<br>";
    }
}

echo "Database initialization complete!";
$conn->close();
?>