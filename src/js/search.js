document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadProducts(searchInput.value);
        }, 300);
    });
});

function loadProducts(searchTerm = '') {
    const productsContainer = document.getElementById('products-container');
    
    fetch(`api/get_products.php?search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(products => {
            productsContainer.innerHTML = '';
            
            if (products.length === 0) {
                productsContainer.innerHTML = '<p class="no-results">No products found</p>';
                return;
            }
            
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                
                const inStock = product.quantity > 0;
                const buttonState = inStock ? '' : 'disabled';
                const stockMessage = inStock ? `In stock: ${product.quantity}` : 'Out of stock';
                
                productCard.innerHTML = `
                    <img src="${product.image_path}" alt="${product.product_name}">
                    <h3>${product.product_name}</h3>
                    <p class="desc">${product.desc}</p>
                    <p class="price">$${product.unit_price}</p>
                    <p class="stock">${stockMessage}</p>
                    <button onclick="addToCart(${product.prod_id}, '${product.product_name}', ${product.unit_price})" ${buttonState}>
                        Add to Cart
                    </button>
                `;
                
                productsContainer.appendChild(productCard);
            });
        })
        .catch(error => {
            console.error('Error loading products:', error);
            productsContainer.innerHTML = '<p class="error">Failed to load products</p>';
        });
}