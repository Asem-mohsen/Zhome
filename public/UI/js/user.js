
$(document).ready(function() {
    $('nav ul li').click(function() {
        $('nav ul li').removeClass('current');
        $(this).addClass('current');
    });
});


var currentUrl = window.location.href;
$('nav ul li a').each(function() {
if ($(this).attr('href') === currentUrl) {
    $(this).parent().addClass('current');
}
});



function addToCart(productId, price, installationCost)  {
    axios.post('/Cart/add', {
        product_id: productId,
        quantity: 1,
        price: price,
        installation_cost: installationCost
    })
    .then(response => {
        updateCartCount();
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
    });
}

function removeFromCart(productId) {
    axios.delete(`/Cart/remove/${productId}`)
    .then(response => {
        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
        row.remove();
        updateTotalPrice();
        updateCartCount();
    })
    .catch(error => {
        console.error('Error removing from cart:', error);
    });
}

function updateCartCount() {
    axios.get('/Cart/count')
    .then(response => {
        $('#TotalItems').text = response.data.count;
        $('#cart-count').text = response.data.count;
    })
    .catch(error => {
        console.error('Error updating cart count:', error);
    });
}

function checkout() {
    const rows = document.querySelectorAll('tr[data-product-id]');
    const cartData = [];
    let totalPrice = 0;
    let savedAmount = parseFloat(document.getElementById('SavedAjax').value) || 0;
    
    rows.forEach(row => {
        const productId = row.dataset.productId;
        const quantity = row.querySelector('.Quantity').value;
        const installmentCheckbox = row.querySelector('.installmentPriceCheckbox');
        const installmentPrice = installmentCheckbox && installmentCheckbox.checked ? 1 : 0;
        const price = parseFloat(row.querySelector('.ProductPrice').value);

        const rowTotal = (quantity * price) + installmentPrice;
        totalPrice += rowTotal;

        cartData.push({
            product_id: productId,
            quantity: quantity,
            installation_cost: installmentPrice,
            subtotal: rowTotal
        });
    });
    
    const finalTotal = totalPrice - savedAmount;

    axios.post('/Cart/update', { 
        cart: cartData,
        total_price: totalPrice,
        saved_amount: savedAmount,
        final_total: finalTotal
    })
    .then(response => {
        window.location.href = '/Checkout/';
    })
    .catch(error => {
        console.error('Error updating cart:', error);
    });
}

// Call updateCartCount() when the page loads
document.addEventListener('DOMContentLoaded', updateCartCount);
