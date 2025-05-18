<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Shopping Cart</h1>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
                <a href="inventory.php">Manage Inventory</a>
            </div>
        </header>
        
        <main>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Cart items will be loaded here dynamically -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td id="cart-total">$0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
            <button id="checkout-btn" class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
        </main>
    </div>

    <script src="js/cart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderCart();
        });
        
        function checkout() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            fetch('api/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ items: cart })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Checkout successful! Thank you for your purchase.');
                    localStorage.removeItem('cart');
                    cart = [];
                    updateCartCount();
                    renderCart();
                } else {
                    alert('Checkout failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error during checkout:', error);
                alert('An error occurred during checkout. Please try again.');
            });
        }
    </script>
</body>
</html>