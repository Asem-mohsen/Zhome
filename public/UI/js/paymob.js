// Payment gatway PayMob 
  const API = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam81TnpZM01YMC5NdE5tWDhlZTljbzRJWHR1Rm0yN0lNTWdZZ1ZLZHpnbmRrcWNFenpBM0R6cTBtbWNzUV9RMmV2eElLUzlQMllld2RUZE43UWtEb3ZNUEZ4MWYxU2pfUQ==";


// Cart 
 function checkout() {
    // Collect user and product details from the form
    const userData = {
        Name: document.getElementById("FirstName").value,
        LastName: document.getElementById("LastName").value,
        Email: document.getElementById("UserEmail").value,
        Phone: document.getElementById("UserPhone").value,
        Address: $("#UserShippingAddress").val(),
        City: document.getElementById("UserCity").value,
        Building: document.getElementById("UserBuilding").value,
        Floor: document.getElementById("UserFloor").value,
        Apartment: document.getElementById("UserApartment").value,
        Country: document.getElementById("UserCountry").value,

    };
    if (!userData.Name || !userData.Email || !userData.Phone || !userData.Address || !userData.City || !userData.Building || !userData.Floor || !userData.Apartment) {
            alert("Please fill in all the required fields.");
        return; 
    }
    // Collect product details from the form
    const products = [];
    const productForms = document.querySelectorAll('.product-form');
    
    productForms.forEach(form => {
        const productName = form.querySelector('.product-name').value;
        const productQuantity = form.querySelector('.product-quantity').value;
        const productPrice = form.querySelector('.product-price').value;

        products.push({
            name: productName,
            quantity: productQuantity,
            price: productPrice,
        });
    });
    // Call the PayMob integration steps with dynamic data
    FirstStepcheckout(userData, products);
}

  async function FirstStepcheckout(userData, products){
    let data = {
      "api_key" : API
    };
    let request = await fetch('https://accept.paymob.com/api/auth/tokens' , {
      method : 'POST',
      headers: {'Content-Type' :'application/json'},
      body : JSON.stringify(data)
    });

    let response = await request.json();
    var token = response.token;
    SecondStepcheckout(token, userData, products);

  }

  async function SecondStepcheckout(token, userData, products){
      let MainTotalBEFOREpromo = $('#TotalCheckout').val();
      let MainTotalAfterPromo = $('#TotalCheckoutAfterPromo').val();

    let dynamicValue = MainTotalAfterPromo ? parseInt(MainTotalAfterPromo) : MainTotalBEFOREpromo; 

   let items = products.map(product => ({
        "name": product.name,
        "amount_cents": product.price * 100, // Convert to cents
        "description": product.name,
        "quantity": product.quantity
    }));
    
    let data = {
        "auth_token": token,
        "delivery_needed": "false",
        "amount_cents": dynamicValue  * 100, // Convert to cents
        "currency": "EGP",
        "items": items,
    };
    let request = await fetch('https://accept.paymob.com/api/ecommerce/orders' , {
      method : 'POST',
      headers: {'Content-Type' :'application/json'},
      body : JSON.stringify(data)
    });

    let response = await request.json();
    let id = response.id;
    ThirdStepcheckout(token, id, userData, products);
    
  }
  
  async function ThirdStepcheckout(token, id, userData, products){
        let MainTotalBEFOREpromo = $('#TotalCheckout').val();
      let MainTotalAfterPromo = $('#TotalCheckoutAfterPromo').val();

    let dynamicValue = MainTotalAfterPromo ? parseInt(MainTotalAfterPromo) : MainTotalBEFOREpromo; 
      let data = {
        "auth_token": token,
        "amount_cents": dynamicValue  * 100,
        "expiration": 3600,
        "order_id": id,
        "billing_data": {
            "first_name": userData.Name,  
            "last_name": userData.LastName, 
            "email": userData.Email,
            "phone_number": userData.Phone,
            "street": userData.Address,
             "apartment": userData.Apartment, 
           "floor": userData.Floor, 
          "building": userData.Building, 
          "city": userData.City, 
          "country": userData.Country, 
          "last_name": userData.LastName,

        },
        "currency": "EGP",
        "integration_id": 4417643,
        "lock_order_when_paid": "false",
    };
    let request = await fetch('https://accept.paymob.com/api/acceptance/payment_keys', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    let response = await request.json();
    let Thirdtoken = response.token;

    CardPayment(Thirdtoken);


}




// Service
 function checkoutService() {
    // Collect user and product details from the form
    const userData = {
        Name: document.getElementById("UserName").value,
        Email: document.getElementById("UserEmail").value,
        Phone: document.getElementById("UserPhone").value,
        Address: document.getElementById("UserAddress").value,
    };

    // Collect product details from the form
    const services = [];
   const ServiceTableForms = document.querySelectorAll('.ServiceTable');

    ServiceTableForms.forEach(form => {
    
        const rows = form.querySelectorAll('tr');
        rows.forEach(row => {
            const timeInputs = row.querySelectorAll('.ServiceTime');
    
            timeInputs.forEach(timeInput => {
                if (timeInput.checked) {
                    const ServiceTime = timeInput.value;
                    const ServicePrice = row.querySelector('.ServicePrice').value;
                    const ServiceDate = row.querySelector('.ServiceDate').value;
                    // Push the checked time details into the services array
                    services.push({
                        date: ServiceDate,
                        time: ServiceTime,
                        price: ServicePrice,
                    });
                }
            });
        });
    });

    FirstStep(userData, services);
}

  async function FirstStep(userData, services){
    let data = {
      "api_key" : API
    };
    let request = await fetch('https://accept.paymob.com/api/auth/tokens' , {
      method : 'POST',
      headers: {'Content-Type' :'application/json'},
      body : JSON.stringify(data)
    });

    let response = await request.json();
    var token = response.token;
    SecondStep(token, userData, services);
  }

  async function SecondStep(token, userData, services){
      
   let items = services.map(service => ({
        "name": "Video Call",
        "amount_cents": service.price * 100, // Convert to cents
        "description": "Video Call",
        "date": service.date,
        "time": service.time
    }));
    
    let data = {
        "auth_token": token,
        "delivery_needed": "false",
        "amount_cents": services.reduce((total, service) => total + service.price * 100, 0), // Convert to cents
        "currency": "EGP",
        "items": items,
    };
    let request = await fetch('https://accept.paymob.com/api/ecommerce/orders' , {
      method : 'POST',
      headers: {'Content-Type' :'application/json'},
      body : JSON.stringify(data)
    });
    
    let response = await request.json();
    let id = response.id;
    ThirdStep(token, id, userData, services);
    
  }
async function ThirdStep(token, id, userData, services) {
    let data = {
        "auth_token": token,
        "amount_cents": services.reduce((total, service) => total + service.price * 100, 0), // Convert to cents
        "expiration": 3600,
        "order_id": id,
        "billing_data": {
            "first_name": userData.Name,
            "email": userData.Email,
            "phone_number": userData.Phone,
            "street": userData.Address,
            "apartment": "1",
            "floor": "1",
            "building": "1",
            "city": "Cairo",
            "country": "Egypt",
            "last_name": "m",
        },
        "currency": "EGP",
        "integration_id": 245216,
        "lock_order_when_paid": "false"
    };

    // Using fetch
    let request = await fetch('https://accept.paymob.com/api/acceptance/payment_keys', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    let response = await request.json();
    let Thirdtoken = response.token;
    CardPayment(Thirdtoken);
}



  async function CardPayment(Thirdtoken){
     let IframeURL = `https://accept.paymob.com/api/acceptance/iframes/228615?payment_token=${Thirdtoken}`;
     location.href = IframeURL;
  }
    async function ValuePayment(Thirdtoken){
     let IframeURL = `https://accept.paymob.com/api/acceptance/iframes/1630266?payment_token=${Thirdtoken}`;
     location.href = IframeURL;
  }



// COD 
 function COD() {


    const userID = document.getElementById("user_id").value;
    const Name = document.getElementById("UserName").value;
    const FirstName = document.getElementById("FirstName").value;
    const LastName = document.getElementById("LastName").value;
    const FullName = FirstName  + " " + LastName ;
    const Email = document.getElementById("UserEmail").value;
    const Phone = document.getElementById("UserPhone").value;
    const ShippingAddress = $("#UserShippingAddress").val();
    const UserMainAddress = $("#UserMainAddress").val();
    const City = document.getElementById("UserCity").value;
    const Building = document.getElementById("UserBuilding").value;
    const Floor = document.getElementById("UserFloor").value;
    const Apartment = document.getElementById("UserApartment").value;
    const Country = document.getElementById("UserCountry").value;


    if (!Name || !Email || !Phone || !ShippingAddress || !City || !Building || !Floor || !Apartment || !UserMainAddress ) {
            alert("Please fill in all the required fields.");
        return; 
    }
    
    const products = [];
    const productForms = document.querySelectorAll('.product-form');
    
    productForms.forEach(form => {
        const productName = form.querySelector('.product-name').value;
        const productQuantity = form.querySelector('.product-quantity').value;
        const productPrice = form.querySelector('.product-price').value;

        products.push({
            name: productName,
            quantity: productQuantity,
            price: productPrice,
        });
    });
    const formData = new FormData();
    formData.append('userID', userID);
    formData.append('Name', Name);
    formData.append('FullName', FullName);
    formData.append('Email', Email);
    formData.append('Phone', Phone);
    formData.append('ShippingAddress', ShippingAddress);
    formData.append('UserMainAddress', UserMainAddress);
    formData.append('City', City);
    formData.append('Building', Building);
    formData.append('Floor', Floor);
    formData.append('Apartment', Apartment);
    formData.append('Country', Country);

    products.forEach((product, index) => {
        formData.append(`products[${index}][name]`, product.name);
        formData.append(`products[${index}][quantity]`, product.quantity);
        formData.append(`products[${index}][price]`, product.price);
    });
    
     fetch('CashOnDelivery.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const transactionID = data.transactionID; // Assuming the server sends back the transactionID
            window.location.href = './Cart.php?action=Success&TransactionID=' + transactionID + '#Success';
        } else {
            // Handle unsuccessful response if needed
        }
    })
    .catch(error => {
        console.error('Error during AJAX request:', error);
    });
}