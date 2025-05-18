<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Inventory Management</h1>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
                <a href="inventory.php">Manage Inventory</a>
            </div>
        </header>
        
        <main>
            <div class="inventory-form">
                <h2>Add New Product</h2>
                <form id="add-product-form">
                    <div class="form-row">
                        <input type="text" id="product-name" placeholder="Product Name" required>
                    </div>
                    <div class="form-row">
                        <textarea id="product-desc" placeholder="Product Description" required></textarea>
                    </div>
                    <div class="form-row">
                        <input type="number" id="product-price" placeholder="Unit Price" min="0" required>
                    </div>
                    <div class="form-row">
                        <input type="number" id="product-quantity" placeholder="Quantity Available" min="0" required>
                    </div>
                    <div class="form-row">
                        <input type="number" id="image-code" placeholder="Image Code" min="1" required>
                    </div>
                    <div class="form-row">
                        <button type="submit">Add Product</button>
                    </div>
                </form>
            </div>
            
            <h2>Current Inventory</h2>
            <table class="cart-table" id="inventory-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image Code</th>
                    </tr>
                </thead>
                <tbody id="inventory-items">
                </tbody>
            </table>
        </main>
    </div>

    <script src="js/cart.js"></script>
    <script src="js/inventory.js"></script>
</body>
</html>