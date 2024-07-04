var currentUrl = window.location.href;
$('nav ul li a').each(function() {
    if ($(this).attr('href') === currentUrl) {
        $(this).parent().addClass('current');
    }
});

// Navbar
// document.addEventListener('DOMContentLoaded', function() {
//     const burger = document.querySelector('#burger');
//     const menu = document.querySelector('#menu');
//     const overlay = document.querySelector('.overlay');

//     burger.addEventListener('click', function() {
//         menu.classList.toggle('active');
//         overlay.classList.toggle('active');
//     });

//     overlay.addEventListener('click', function() {
//         menu.classList.remove('active');
//         overlay.classList.remove('active');
//     });

//     function handleResize() {
//         if (window.innerWidth > 768) {
//             menu.classList.remove('active');
//             overlay.classList.remove('active');
//         }
//     }

//     window.addEventListener('resize', handleResize);
// });

// Cart
function addToCart(productId, price, installationCost)  {
    const quantityInput = document.getElementById('quantity-' + productId);
    let quantity = 1; //default
    let totalPrice = price; //default

    if (quantityInput) {
        quantity = parseInt(quantityInput.value);
        totalPrice = quantity * price;
    }

    axios.post('/Cart/add', {
        product_id: productId,
        quantity: quantity,
        price: totalPrice,
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
        $('.count').text(response.data.count);
        $('#TotalItems').innerText = response.data.count;
        
    })
    .catch(error => {
        console.error('Error updating cart count:', error);
    });
}

document.addEventListener('DOMContentLoaded', updateCartCount); // Call updateCartCount() when the page loads

function updateRowTotal(row) {
    const quantity = parseInt(row.querySelector('.Quantity').value);
    const price = parseFloat(row.querySelector('.ProductPrice').value);
    const installmentCheckbox = row.querySelector('.installmentPriceCheckbox');
    const installmentPrice = installmentCheckbox ? parseFloat(installmentCheckbox.value) : 0;
    const savedInput = row.querySelector('.SavedPrice');
    const savedPrice = savedInput  ? parseFloat(savedInput.value) : 0;
    let saved = 0 ;
    if(savedPrice != 0 ){
         saved = (price - savedPrice) * quantity;
    }

    let total = quantity * price;

    if (installmentCheckbox && installmentCheckbox.checked) {
        total += installmentPrice;
    }

    row.querySelector('.SubTotal').textContent = total.toFixed(2) + ' EGP';
    return { total, saved };
}

function updateTotalPrice() {
    const rows = document.querySelectorAll('tr[data-product-id]');
    let grandTotal = 0;
    let totalSaved = 0;

    rows.forEach(row => {
        const { total, saved } = updateRowTotal(row);
        grandTotal += total;
        totalSaved += saved;
    });
    document.getElementById('FinalTotal').textContent = grandTotal.toFixed(2) + ' EGP';
    document.getElementById('TotalPriceOne').textContent = grandTotal.toFixed(2) + ' EGP';
    document.getElementById('discountDiv2').textContent = totalSaved.toFixed(2) + ' EGP';
    document.getElementById('totalSaved').value = totalSaved.toFixed(2);

}

function checkout() {
    const rows = document.querySelectorAll('tr[data-product-id]');
    const cartData = [];
    let totalPrice = 0;
    let savedAmount = parseFloat(document.getElementById('totalSaved').value) || 0;

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
// End Cart


// Checkout Page functions
function applyPromoCode() {
    const promoCodeInput = document.getElementById('promoCodeInput');
    const promoCode = promoCodeInput.value;

    if (promoCode) {
        axios.post('/Checkout/check-promo-code', { promoCode: promoCode, totalPrice: totalPrice })
            .then(response => {
                promoCodeDiscount = response.data.discount;
                document.getElementById('promocode').textContent = promoCodeDiscount.toFixed(2) + ' EGP';
                document.getElementById('promocode-div').style.display = 'block';
                displayTotalPrice();
            })
            .catch(error => {
                console.error('Error checking promo code:', error);
                promoCodeDiscount = 0;
                document.getElementById('promocode').textContent = '0.00 EGP';
                document.getElementById('promocode-div').style.display = 'none';
                displayTotalPrice();
            });
    } else {
        promoCodeDiscount = 0;
        document.getElementById('promocode').textContent = '0.00 EGP';
        document.getElementById('promocode-div').style.display = 'none';
        displayTotalPrice();
    }
}

function applyDeliveryCost() {
    const citySelect = document.getElementById('UserCity');
    const selectedCity = citySelect.value;

    if (selectedCity) {
        axios.post('/Checkout/get-delivery-cost', { city: selectedCity })
            .then(response => {
                deliveryCost = response.data.deliveryCost;
                document.getElementById('deliveryFees').textContent ="Delivery Fees: " + deliveryCost.toFixed(2) + ' EGP';
                document.getElementById('deliveryFeesValue').value = deliveryCost.toFixed(2);
                displayTotalPrice();
            })
            .catch(error => {
                console.error('Error getting delivery cost:', error);
                deliveryCost = 0;
                document.getElementById('deliveryFees').style.display = 'none'
                document.getElementById('deliveryFees').textContent = '0.00 EGP';
                document.getElementById('deliveryFeesValue').value = '0.00';
                displayTotalPrice();
            });
    } else {
        deliveryCost = 0;
        document.getElementById('deliveryFees').style.display = 'none'
        document.getElementById('deliveryFees').textContent = '0.00 EGP';
        document.getElementById('deliveryFeesValue').value = '0.00';
        displayTotalPrice();
    }
}

function displayTotalPrice() {
    const finalTotal = totalPrice - promoCodeDiscount + deliveryCost;

    document.getElementById('FinalBeforePromoHide').textContent = messages.total + ` ${totalPrice.toFixed(2)} EGP`;
    document.getElementById('FinalCheckout').textContent = `${finalTotal.toFixed(2)} EGP`;
    document.getElementById('FinalBeforePromoHide').style.display = (promoCodeDiscount > 0 || deliveryCost > 0) ? 'none' : 'block';
    document.getElementById('FinalCheckoutHide').style.display = (promoCodeDiscount > 0 || deliveryCost > 0) ? 'block' : 'none';
    document.getElementById('TotalCheckout').value = totalPrice.toFixed(2);
    document.getElementById('TotalCheckoutAfterPromo').value = finalTotal.toFixed(2);
}
// End Checkout Page
