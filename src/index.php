<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>E-Commerce Website</h1>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
                <a href="inventory.php">Manage Inventory</a>
            </div>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search products...">
            </div>
        </header>
        
        <main>
            <div class="products-grid" id="products-container">
            </div>
        </main>
    </div>

    <script src="js/search.js"></script>
    <script src="js/cart.js"></script>
</body>
</html>