document.addEventListener('DOMContentLoaded', function() {
    loadInventory();
    
    const addProductForm = document.getElementById('add-product-form');
    
    addProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productData = {
            product_name: document.getElementById('product-name').value,
            description: document.getElementById('product-desc').value,
            unit_price: document.getElementById('product-price').value,
            image_code: document.getElementById('image-code').value,
            quantity: document.getElementById('product-quantity').value
        };
        
        addProduct(productData);
    });
});

function loadInventory() {
    fetch('api/inventory.php')
        .then(response => response.json())
        .then(products => {
            const inventoryItems = document.getElementById('inventory-items');
            inventoryItems.innerHTML = '';
            
            if (products.length === 0) {
                inventoryItems.innerHTML = '<tr><td colspan="6" class="empty-inventory">No products in inventory</td></tr>';
                return;
            }
            
            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.prod_id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.desc.substring(0, 50)}${product.desc.length > 50 ? '...' : ''}</td>
                    <td>$${product.unit_price}</td>
                    <td>${product.quantity}</td>
                    <td>${product.image_code}</td>
                `;
                
                inventoryItems.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error loading inventory:', error);
            document.getElementById('inventory-items').innerHTML = 
                '<tr><td colspan="6" class="error">Failed to load inventory</td></tr>';
        });
}

function addProduct(productData) {
    fetch('api/inventory.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added successfully!');
            document.getElementById('add-product-form').reset();
            loadInventory();
        } else {
            alert('Failed to add product: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error adding product:', error);
        alert('An error occurred while adding the product');
    });
}