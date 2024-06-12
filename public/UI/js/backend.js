$(function () {
  "use strict";

    // Class Active
    $(document).ready(function() {
          $('nav ul li').click(function() {
              $('nav ul li').removeClass('current');
              $(this).addClass('current');
          });
      });

    // :: 12.0 PreventDefault a Click
    $("a[href='#']").on('click', function ($) {
      $.preventDefault();
    });


    // :: 11.0 Slider Range Price Active Code
    $('.slider-range-price').each(function () {
      var min = jQuery(this).data('min');
      var max = jQuery(this).data('max');
      var unit = jQuery(this).data('unit');
      var value_min = jQuery(this).data('value-min');
      var value_max = jQuery(this).data('value-max');
      var label_result = jQuery(this).data('label-result');
      var t = $(this);
    
      $(this).slider({
        range: true,
        min: min,
        max: max,
        values: [value_min, value_max],
        slide: function (event, ui) {
          var result = label_result + " " + unit + ui.values[0] + ' - ' + unit + ui.values[1];
          t.closest('.slider-range').find('.range-price').html(result);
        },
        stop: function (event, ui) {
          var minValue = ui.values[0];
          var maxValue = ui.values[1];
    
          $.ajax({
            url: './PriceRange.php',
            type: 'POST',
            data: {
              minValue: minValue,
              maxValue: maxValue
            },
            success: function(response) {
              var priceData = JSON.parse(response);
            //   window.location.href = '?action=ApplyFilter&PriceBetween='+ priceData.min_price + ',' + priceData.max_price;
            },
            error: function(xhr, status, error) {
              // Handle errors
              console.error('Error:', error);
            }
          });
        }
      });
    });


      var currentUrl = window.location.href;
      $('nav ul li a').each(function() {
              if ($(this).attr('href') === currentUrl) {
                  $(this).parent().addClass('current');
              }
          });

  //Hide placeholder when foucs
  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  // Add * on Required fileds
  $('input').each(function () {
    if ($(this).attr('required') === 'required') {
        $(this).after('<span class="asterisk"> * </span>');
    }
  });


    // Loader
    $(document).ready(function() {
        // Hide the loader and logo when the page is fully loaded
        $(window).on('load', function() {
             $('#loader').hide();
            $('#loader-container').fadeOut(500, function() {
                // Show the content and restore overflow
                $('#Zhomecontent').fadeIn(500);
                $('body').css('overflow', 'auto');
            });
        });
    });



  //Confirmation message on delete button
  $('.confirm').click(function(){
    return confirm('Are You Sure ?');
  });


  // Increase and Decress button Quantity
  $(document).ready(function(){
    $('.increament-btn').click(function(e){
      e.preventDefault();
      var quantity = $(this).closest('.product-data').find('.input-quantity').val();
      var value = parseInt(quantity , 10);
      value = isNaN(value) ? 0 : value ;
      if(value < 10 ){
          value++;
          $(this).closest('.product-data').find('.input-quantity').val(value);
      }
    })
    $('.decreament-btn').click(function(e){
      e.preventDefault();
      var quantity = $(this).closest('.product-data').find('.input-quantity').val();
      var value = parseInt(quantity , 10);
      value = isNaN(value) ? 0 : value ;
      if(value > 1 ){
          value--;
          $(this).closest('.product-data').find('.input-quantity').val(value);
      }
    })
  });


    // Add to Cart
    var TotalPrice = 0;
      $('[name="Add_to_cart"]').click(function() {

        var button = $(this);
        var icon = button.find('i');
        // Get the product ID of the product that you want to add to the cart.
        var productOneSingle = $(this).closest('.product-one__single');
        var ProductID = productOneSingle.find('[name="ProductID"]').val();
        var UserID = productOneSingle.find('[name="UserID"]').val();
        var RegularPrice = productOneSingle.find('[name="Price"]').val();
        var ProductName = productOneSingle.find('[name="ProductName"]').val();
        var ProductImage = productOneSingle.find('[name="ProductImage"]').val();
        var SalePrice = $(this).closest('.product-one__content-right').find('[name="PriceAfterSale"]').val(); // Assuming this field contains the sale price
      
        var AddToCart = 1;
        var Quantity = 1;
        // Send an AJAX request to add the product to the cart.
        var Price = SalePrice || RegularPrice;
          $.ajax({
              method: 'POST',
              url: 'https://zhome.com.eg/Front/UserAjax.php',
              data: {
                  ProductID: ProductID,
                  UserID: UserID,
                  Price: (SalePrice ? SalePrice : RegularPrice),
                  AddToCart: AddToCart,
                  Quantity: Quantity
              },
              success: function(response) {
                  icon.removeClass('fa-cart-shopping').addClass('fa-check');
                  button.prop('disabled', true); 
                  updateCartCount();
                  updateCartProducts();
                TotalPrice += parseFloat(Price); 
                   const productInfo = {
                        name: ProductName,
                        price: Price,
                        image: ProductImage
                    };
                    addToCartDrop(productInfo);
              },
              error: function(error) {
                  // Handle errors gracefully
                  console.error('Error adding product to cart:', error);
                  icon.removeClass('fa-cart-shopping').addClass('fa-exclamation');
                  button.prop('disabled', false); // Re-enable the button
                  alert('Error adding product to cart. Please try again later.');
              }
          });
      });

  });

var addedItems = [];

function addToCartDrop(productInfo) {
    addedItems.push(productInfo);
    showCartElements();

}
    
function updateCartProducts() {
    $.ajax({
        type: 'GET',
        url: 'https://zhome.com.eg/Front/GetCartProducts.php',
        success: function(response) {
            
            $('#productInfo').html(response);
            showCartElements();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX error:', errorThrown);
            alert('Failed to retrieve cart products. Please check the console for details.');
        }
    });
}  


function showCartElements() {
    var cartDropdown = document.getElementById("cartDropdown");
    var cartIcon = document.getElementById("cartIcon");

    if (addedItems.length > 0) {
         toggleCartIcon(true);
        cartDropdown.style.display = "block";
        updateTotalDrop();
    }
}


var scrollingTimer;
var cartIconVisible = false;
var userClosedCart = false;
function closeCart() {
    var cartDropdown = document.getElementById("cartDropdown");
    var cartIcon = document.getElementById("cartIcon");
    cartDropdown.style.display = "none";
    cartIcon.style.display = "none";
    cartDropdown.style.transition = "all 0.4s ease-in-out";
    cartIcon.style.transition = "all 0.4s ease-in-out";
}

function minimizeCart() {
    closeCart();
}

function updateCartPosition() {
    var cartIcon = document.getElementById("cartIcon");
    var cartDropdown = document.getElementById("cartDropdown");

    if (!cartIcon || !cartDropdown) {
        return;
    }

    var screenWidthThreshold = 768;

    if (window.innerWidth < screenWidthThreshold) {
        cartDropdown.style.position = "fixed";
        cartDropdown.style.top = "0";
        cartDropdown.style.right = "0";
        return;
    }

    clearTimeout(scrollingTimer);

    scrollingTimer = setTimeout(function () {
        if (addedItems.length > 0 && !userClosedCart) {
            toggleCartIcon(true);
            cartDropdown.style.display = "block";
        }
    }, 1000);

    var windowHeight = window.innerHeight;
    var iconTopPosition = cartIcon.getBoundingClientRect().top;

    if (iconTopPosition < 0 || iconTopPosition > windowHeight) {
        toggleCartIcon(true);
        closeCart();
    } else if (cartIconVisible && !userClosedCart) {
        toggleCartIcon(false);
        closeCart();
    }
}

window.addEventListener("scroll", updateCartPosition);

var minimizeCartButton = document.getElementById("minimizeCartBtn");
if (minimizeCartButton) {
    minimizeCartButton.addEventListener("click", function () {
        userClosedCart = true;
        closeCart();
        updateCartPosition();
    });
} 

function toggleCartIcon(shouldShow) {
    var cartIcon = document.getElementById("cartIcon");
    cartIconVisible = shouldShow;
    cartIcon.style.display = shouldShow ? "block" : "none";
}

function toggleCart() {
    var cartDropdown = document.getElementById("cartDropdown");
    if (addedItems.length > 0) {
        toggleCartIcon(true);
        cartDropdown.style.display = "block";
    }
}

if(document.getElementById("cartIcon") || document.getElementById("minimizeCartBtn")){
    document.getElementById("cartIcon").addEventListener("click", toggleCart);
    document.getElementById("minimizeCartBtn").addEventListener("click", minimizeCart);
}

// Checkout in cart page
function handleCheckout() {
    var ProductID = document.getElementsByClassName('ProductID');
    var UserID = document.getElementById('UserID');
    var FinalTotal = document.getElementById('FinalTotal');
    var TotalPriceAjax = document.getElementById('TotalPriceAjax');
    var SavedAjax = document.getElementById('SavedAjax');
    var OldProductPrice = document.getElementsByClassName('OldProductPrice');
    var Price = document.getElementsByClassName('ProductPrice');
    var Quantity = document.getElementsByClassName('Quantity');
    var SubTotal = document.getElementsByClassName('SubTotal');
    var Installments = document.getElementsByClassName('.installmentsPrice');
    var FullTotalOne = document.getElementById('TotalPriceOne');
    var TotalSaved = document.getElementById('discountDiv2');
    
    var InstallationLi = document.getElementById('InstallationLi');
    var installmentPriceCheckbox = document.querySelectorAll('.installmentPriceCheckbox');
    var priceBeforeSale = document.getElementsByClassName('BeforeSale');
    var TotalPrice = 0;
    // Array to store cart items
    var cartItems = [];
    for (var i = 0; i < Price.length ; i++) { 
        var productID = ProductID[i].value;
        var quantity = Quantity[i].value;
        var price = Price[i].value;
        var hasInstallment = typeof installmentPriceCheckbox[i] !== "undefined" && installmentPriceCheckbox[i].checked;

        if (hasInstallment) {
            var installmentPrice = parseFloat(installmentPriceCheckbox[i].value);
        }else{
            var installmentPrice = 0;
        }         

        var OldPrice = OldProductPrice[i].value;

        var cartItem = {
            ProductID: productID,
            Quantity: quantity,
            Price: price,
            InstallmentPrice: installmentPrice,
            OldPrice: OldPrice
        };

        cartItems.push(cartItem);

    }

    var Saving = SavedAjax.value;
    var totalPrice = TotalPriceAjax.value;
    var TotalBeforeSaving = parseFloat(Saving) + parseFloat(totalPrice);
    var UserIDAjax = UserID.value;

    $.ajax({
        type: 'POST',
        url: 'https://zhome.com.eg/Front/Insert_cart_data.php',
        data: {
            cartItems: cartItems,
            totalPrice: totalPrice,
            UserID: UserIDAjax,
            Saving: Saving,
            TotalBeforeSaving: TotalBeforeSaving,
        },
        success: function(response) {
            console.log('Response from server:', response);
            if (response === 'success') {
                window.location.href = 'https://zhome.com.eg/Front/Cart.php?action=Checkout';
            } else {
                alert('Insertion failed. Please try again.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX error:', errorThrown);
            alert('AJAX request failed. Please check the console for details.');
        }
    });
}

function handleCheckoutDroppedList() {
    var ProductID = document.getElementsByClassName('ProductID');
    var UserID = document.getElementById('UserIDinNav');
    var OldProductPrice = document.getElementsByClassName('OldProductPrice');
    var PriceList = document.getElementsByClassName('MainPriceList');
    var SalePrice = document.getElementsByClassName('SalePriceList');
    var Quantity = document.getElementsByClassName('OrderedQuantity');
    
    // var TotalSaved = 0;
    var cartItems = [];
     var TotalPrice = 0;
     
    for (var i = 0; i < PriceList.length; i++) {
        var productID = ProductID[i].value;
        var quantity = Quantity[i].value;
        var price = PriceList[i].value;
        var OldPrice = PriceList[i].value;
        var savedPrice = 0; 
        var SalePriceNum = SalePrice[i].value;

        if (SalePriceNum && SalePriceNum !== '0') {
            savedPrice = parseFloat(price) - parseFloat(SalePriceNum);
        }
          var Price = SalePriceNum !== null && SalePriceNum !== '0' ? SalePriceNum : price;
        TotalPrice += parseFloat(Price);

        var cartItem = {
            ProductID: productID,
            Quantity: quantity,
            Price: Price,
            InstallmentPrice: 0,
            OldPrice: OldPrice,
            SavedPrice: savedPrice
        };

        cartItems.push(cartItem);
    }

    var UserIDAjax = UserID.value;

    $.ajax({
        type: 'POST',
        url: 'https://zhome.com.eg/Front/Insert_cart_data.php',
        data: {
            cartItems: cartItems,
            totalPrice: TotalPrice,
            UserID: UserIDAjax,
        },
        success: function(response) {
            console.log('Response from server:', response);
            if (response === 'success') {
                window.location.href = 'https://zhome.com.eg/Front/Cart.php?action=Checkout';
            } else {
                
                alert('Insertion failed. Please try again.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX error:', errorThrown);
            alert('AJAX request failed. Please check the console for details.');
        }
    });
}

function updateTotalDrop() {
     var totalPriceListValue = document.getElementById('TotalPriceList').value;
    var totalDropElement = document.getElementById('TotalDrop');
        totalDropElement.innerText = parseFloat(totalPriceListValue).toFixed(1) + ' EGP';
}

document.addEventListener('DOMContentLoaded', function() {
    var Price = document.getElementsByClassName('ProductPrice');
    
    for (var i = 0; i < Price.length; i++) {
        Price[i].addEventListener('input', function() {
            handleCheckoutDroppedList();
        });
    }
});

function removeProduct(ProductID) {
    var UserID = $('.CartandCount').closest('.CartProducts').find('.UserID').val();
    $.ajax({
        method: 'POST',
        url: 'https://zhome.com.eg/Front/UserAjax.php',
        data: {
            ProductID: ProductID,
            UserID: UserID,
            RemoveProduct: 1
        },
        success: function(response) {
            var row = $('#myTable tr[data-product-id="' + ProductID + '"]');
            row.remove();
            updateCartCount();
        }
    });
}

function emptyCart() {
    var UserID = $('.CartandCount').closest('.CartProducts').find('.UserID').val();

    $.ajax({
        method: 'POST',
        url: 'https://zhome.com.eg/Front/UserAjax.php',
        data: {
            UserID: UserID,
            RemoveAll: 1
        },
        success: function(response) {
            $('#myTable').empty();
            updateCartCount();
            window.location.href = 'https://zhome.com.eg/Front/Cart.php';
        }
    });
}

//Search
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.querySelectorAll("#TableData");
    for (i = 0; i < tr.length; i++) {
      const tableData = tr[i].getElementsByTagName("td");
      let allTextContent = '';
      for (let ind = 0; ind < tableData.length; ind++) {
          allTextContent += tableData[ind].innerText;
      }
      
      if (allTextContent) {
        if (allTextContent.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }

  // Location
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(saveLocation);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }

  function saveLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    // Send the location data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "UserAjax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
      }
    };
    xhr.send("latitude=" + latitude + "&longitude=" + longitude);
  }


  // Update the Count of Products 
  function updateCartCount() {
    $.ajax({
        method: 'POST',
        url: 'https://zhome.com.eg/Front/CountCartAjax.php',
        data: {
            getCartCount: 1
        },
        success: function(response) {
            // Update the cart count element with the response
            $('span#cart-count').text(response);
        },
        error: function(xhr, status, error) {
        // Handle error response
        console.error(error);
        }
    });
}

//   Promocode
function applyPromocode() {
        var TotalPrice = $('#TotalCheckout');
        var FinalTotal = $('#FinalCheckout');
        var FinalTotalHide = $('#FinalCheckoutHide');
        var promoCodeInput = $('#promoCodeInput');
        var discountDiv = $('#discountDiv');
        var promocodeDiv = $('#promocode-div');
        var FinalBeforePromoHide = $('#FinalBeforePromoHide');
        var UserID = $('#user_id').val();
        var PromocodeButton = $('#checkPromoCodeButton');
        var TotalWithDelivery = $('#TotalWithDelivery');

        // Assuming you have multiple elements with the class 'OrdersID'
        var OrderIDs = $('.OrdersID').toArray().map(element => element.value);

        var promoCode = promoCodeInput.val();

        $.ajax({
            method: 'POST',
            url: './UserAjax.php',
            data: {
                promoCode: promoCode,
                UserID: UserID,
                OrderID: OrderIDs,
            },
            success: function (response) {
                if (response === '' || response === 'Invalid promocode') {
                    discountDiv.html("Please Type Valid Promocode");
                } else {
                    var Discount = parseFloat(response);
                    DiscountAmount = TotalPrice.val() * Discount / 100;
                    $('#promocode').text("-" + DiscountAmount + " EGP");
                    $('#successPopup').show();
                    TotalPrice.hide();
                    FinalTotal.text(TotalPrice.val() - DiscountAmount + " EGP");
                    $('#TotalCheckoutAfterPromo').val(TotalPrice.val() - DiscountAmount);
                    FinalTotal.show();
                    FinalTotalHide.show();
                    FinalBeforePromoHide.hide();
                    TotalWithDelivery.hide();
                    $('#checkPromoCodeButton').hide();
                    promocodeDiv.show();
                    setTimeout(hideSuccessPopup, 3000);
                }
            }
        });
    }


// function sendDataToPHP(inputElement) {
//     var name = inputElement.getAttribute('name');
//     var value = inputElement.value;
//     var originalValue = inputElement.getAttribute('data-original-value') || '';

//     var userid = document.getElementById('user_id').value;

//     var data = {
//         UserID: userid,
//         OriginalValue: originalValue,
//     };
//     data[name] = value;

//     $.ajax({
//         type: "POST",
//         url: "https://zhome.com.eg/Front/Checkout.php",
//         data: data,
//         success: function (response) {
//             // Parse the JSON response
//             var jsonResponse = JSON.parse(response);
//             console.log(jsonResponse.updateOrderQuery);
//             console.log(jsonResponse.updateUserQuery);
//             // Update input styling based on success or failure
//             if (jsonResponse.status === 'success') {
//                 inputElement.style.borderColor = 'green';
//             } else {
//                 inputElement.style.borderColor = 'red';
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error(error);
//             inputElement.style.borderColor = 'red';
//         }
//     });
// }
function sendDataToPHP(inputElement) {
    // Check if the input element id is not 'promoCodeInput'
    if (inputElement.id !== 'promoCodeInput') {
        var name = inputElement.getAttribute('name');
        var value = inputElement.value;
        var originalValue = inputElement.getAttribute('data-original-value') || '';

        var userid = document.getElementById('user_id').value;

        var data = {
            UserID: userid,
            OriginalValue: originalValue,
        };
        data[name] = value;

        $.ajax({
            type: "POST",
            url: "https://zhome.com.eg/Front/Checkout.php",
            data: data,
            success: function (response) {
                // Parse the JSON response
                var jsonResponse = JSON.parse(response);
                console.log(jsonResponse.updateOrderQuery);
                console.log(jsonResponse.updateUserQuery);
                // Update input styling based on success or failure
                if (jsonResponse.status === 'success') {
                    inputElement.style.borderColor = 'green';
                } else {
                    inputElement.style.borderColor = 'red';
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                inputElement.style.borderColor = 'red';
            }
        });
    }
}

// API Google SignIn
function handleCredentialResponse(response) {
    var responsePayload = response.credential;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://zhome.com.eg/SignWithGoogle.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
       if (xhr.status === 200) {
            if (xhr.responseText.trim() === 'success') {
                window.location.href = 'https://zhome.com.eg/index.php';
            } else if(xhr.responseText.trim() === 'successAdmin'){
                 window.location.href = 'https://zhome.com.eg/Admin/index.php';
            }else {
            console.error('Server response is not "success". the response is ' + xhr.responseText);
            }
        } else {
            console.error('HTTP request failed with status: ' + xhr.status);
        }
    };
    xhr.send('id_token=' + responsePayload);
}

// Capture HTML content and convert to image
function downloadImage() {
    html2canvas(document.querySelector('.Success-div')).then(function(canvas) {
        var imageDataUrl = canvas.toDataURL('image/png');

        var link = document.createElement('a');
        link.href = imageDataUrl;
        link.id = 'DownloadImage';
        link.download = 'success_form.png';

        var linkText = document.createTextNode('Download Image');

        link.appendChild(linkText);

        document.body.appendChild(link);

        link.click();

        // Remove the link from the document (optional, depending on your requirements)
        document.body.removeChild(link);
    });
}


function handleInput() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function() {
        submitToDatabase();
    }, doneTypingInterval);
}

function submitToDatabase() {
    var emailInput = document.getElementById("inputEmail");
    var email = emailInput.value;

    fetch('https://zhome.com.eg/Front/SubscriptionAjax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'email=' + encodeURIComponent(email),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // On success
            emailInput.style.borderBottom = '1px solid green';
            emailInput.disabled = true;
        } else {
            // On failure
            emailInput.style.borderBottom = '1px solid red';
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        // Handle errors if any
        emailInput.style.borderBottom = '1px solid red';
        console.error('Error:', error);
    });
}
// Toogle Button Technologies in shop nav
function setupCollapseBehaviorTechnologies() {
    $('#TechnologiesExamples').on('show.bs.collapse', function () {
        $(this).css('display', 'flex');
        $('#TechnologiesExamplesButton i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });

    $('#TechnologiesExamples').on('hide.bs.collapse', function () {
        $('#TechnologiesExamplesButton i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
  }
  // Toogle Button Categories in shop nav
function setupCollapseBehaviorCategories() {
    $('#CategoryExamples').on('show.bs.collapse', function () {
      $('#CategoryExamplesButton i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });

    $('#CategoryExamples').on('hide.bs.collapse', function () {
      $('#CategoryExamplesButton i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
  }
  // Toogle Button Brands in shop nav
function setupCollapseBehaviorBrands() {
    $('#BrandsExamples').on('show.bs.collapse', function () {
        $(this).css('display', 'flex');
        $('#BrandsExamplesButton i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });
    
    $('#BrandsExamples').on('hide.bs.collapse', function () {
      $('#BrandsExamplesButton i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
  }
  // Toogle Button Platforms in shop nav
function setupCollapseBehaviorPlatforms() {
    $('#PlatformsExamples').on('show.bs.collapse', function () {
      $('#PlatformsExamplesButton i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });

    $('#PlatformsExamples').on('hide.bs.collapse', function () {
      $('#PlatformsExamplesButton i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
  }
  
function openOverlay(overlayId) {
    var overlay = document.getElementById(overlayId);
    overlay.style.display = 'flex';
    overlay.style.animation = 'slideIn 0.5s ease-in-out';
}
function closeOverlay(overlayId) {
    var overlay = document.getElementById(overlayId);
    overlay.style.animation = 'slideOut 0.5s ease-in-out';
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 500);
}


function toggleLanguage() {
    
  var currentLanguage = document.getElementById('LangInput').value;
  var newLanguage = (currentLanguage == 'en') ? 'ar' : 'en';

 window.location.href = 'https://zhome.com.eg/Front/switch_language.php?lang=' + newLanguage;
}


// Function to enforce the disabled state for all inputs with the 'disabled' attribute
function enforceDisabledState() {
    var disabledInputs = document.querySelectorAll('input[disabled]');
    disabledInputs.forEach(function(input) {
        input.addEventListener('input', function(event) {
            event.preventDefault();
            return false;
        });
    });
    setInterval(function() {
        disabledInputs.forEach(function(input) {
            if (!input.hasAttribute('disabled')) {
                input.setAttribute('disabled', 'disabled');
            }
        });
    }, 100);
}

// Call the function when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    enforceDisabledState();
});