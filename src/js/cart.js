let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});

function addToCart(prodId, productName, price) {
    const existingItem = cart.find(item => item.prodId === prodId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            prodId: prodId,
            productName: productName,
            price: price,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    
    alert(`${productName} added to cart!`);
}

function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        cartCount.textContent = totalItems;
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    renderCart();
}

function updateQuantity(index, delta) {
    cart[index].quantity += delta;
    
    if (cart[index].quantity <= 0) {
        removeFromCart(index);
        return;
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    renderCart();
}

function renderCart() {
    const cartTableBody = document.getElementById('cart-items');
    if (!cartTableBody) return;
    
    cartTableBody.innerHTML = '';
    let total = 0;
    
    if (cart.length === 0) {
        cartTableBody.innerHTML = '<tr><td colspan="5" class="empty-cart">Your cart is empty</td></tr>';
        document.getElementById('checkout-btn').disabled = true;
        document.getElementById('cart-total').textContent = '$0.00';
        return;
    }
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.productName}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>
                <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                ${item.quantity}
                <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
            </td>
            <td>$${itemTotal.toFixed(2)}</td>
            <td><button class="remove-btn" onclick="removeFromCart(${index})">Remove</button></td>
        `;
        
        cartTableBody.appendChild(row);
    });
    
    document.getElementById('checkout-btn').disabled = false;
    document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
}