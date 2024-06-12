//Wizard Init

$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="number">#index#</span>'
});

//Form control

$('.purpose-radio-input.installed').on('change', function(e) {
    $('#Installed').text(e.target.value);
    $('#enteredInstalledHidden').val(e.target.value);
});
$('.purpose-radio-input.Building').on('change', function(e) {
    $('#BuildingType').text(e.target.value);
    $('#enteredBuildingHidden').val(e.target.value);
});
$('.purpose-radio-input.RoomsInput').on('change', function(e) {
    $('#Rooms').text(e.target.value);
    $('#enteredRoomsHidden').val(e.target.value);
});
$('.purpose-radio-input.SystemTypeInput').on('change', function(e) {
    $('#System').text(e.target.value);
    $('#enteredSystemHidden').val(e.target.value);
});
$('.purpose-radio-input.PackageInput').on('change', function(e) {
    $('#Package').text(e.target.value);
    $('#enteredPackageHidden').val(e.target.value);
});
$('.purpose-radio-input.PlatformsInputs').on('change', function(e) {
     var selectedPlatforms = $('.purpose-radio-input.PlatformsInputs:checked').map(function() {
        return this.value;
    }).get();

    $('#Platforms').text(selectedPlatforms.join(' - '));
     $('#enteredPlatformsHidden').val(selectedPlatforms.join('-'));

});
$('.purpose-radio-input.CategoriesInputs').on('change', function(e) {
     var selectedCategories = $('.purpose-radio-input.CategoriesInputs:checked').map(function() {
        return this.value;
    }).get();

    $('#Categories').text(selectedCategories.join(' - '));
     $('#enteredCategoriesHidden').val(selectedCategories.join('-'));
});
$('#Name').on('input', function(e) {
    $('#enteredName').text(e.target.value || '');
    $('#enteredNameHidden').val(e.target.value || '');

});

$('#Email').on('input', function(e) {
    $('#enteredEmail').text(e.target.value || '');
    $('#enteredEmailHidden').val(e.target.value || '');
});

$('#Phone').on('input', function(e) {
    $('#enteredPhone').text(e.target.value || '');
    $('#enteredPhoneHidden').val(e.target.value || '');
});

$('#Address').on('input', function(e) {
    $('#enteredAddress').text(e.target.value || '');
    $('#enteredAddressHidden').val(e.target.value || '');

});

$('#City').on('input', function(e) {
    $('#enteredCity').text(e.target.value || '');
    $('#enteredCityHidden').val(e.target.value || '');

});

$('#Country').on('input', function(e) {
    $('#enteredCountry').text(e.target.value || '');
    $('#enteredCountryHidden').val(e.target.value || '');

});


function validateForm() {
    // Check if the required fields have values
    var name = $('#Name').val();
    var email = $('#Email').val();
    var phone = $('#Phone').val();
    var address = $('#Address').val();
    var city = $('#City').val();
    var country = $('#Country').val();

    // Validate other fields as needed
    var installed = $('input[name="Installed"]:checked').val();
    var building = $('input[name="BuildingType"]:checked').val();
    var rooms = $('input[name="Rooms"]:checked').val();
    var system = $('input[name="SystemType"]:checked').val();
    var Package = $('input[name="Package"]:checked').val();
    var platforms = $('.purpose-radio-input.PlatformsInputs:checked').map(function() {
        return this.value;
    }).get();
    var categories = $('.purpose-radio-input.CategoriesInputs:checked').map(function() {
        return this.value;
    }).get();


    if (!name || !email || !phone || !address || !city || !country || !installed || !building || !rooms || !system || !Package || platforms.length === 0 || categories.length === 0) {
        alert("Please fill in all required fields.");
        return false;
    }


    return true;
}


function openPopup() {
    var popup = document.getElementById("Roomspopup");
    popup.style.display = "block";
}

function closePopup() {
    var popup = document.getElementById("Roomspopup");
    popup.style.display = "none";
}

function submitPopup() {
    var inputValue = document.getElementById("otherInput").value;
    closePopup();
}