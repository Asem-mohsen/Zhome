document.addEventListener('DOMContentLoaded', function() {
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const resetBtn = document.getElementById('Reset');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(function(checkbox) {
        updateBorder(checkbox);
    });
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateBorder(this);
        });
    });

    function updateBorder(checkbox) {
        let parentElement = checkbox.closest('.BrandsCheckBox, .PlatformCheckBox, .TechCheckBox');
        if (parentElement) {
            if (checkbox.checked) {
                parentElement.style.border = '1px solid var(--MainColor)';
            } else {
                parentElement.style.border = '1px solid #eee';
            }
        }
        let categoryElement = checkbox.closest('.CategoryCheckBox');
        if (categoryElement) {
            if (checkbox.checked) {
                categoryElement.style.color = 'var(--MainColor)';
            } else {
                categoryElement.style.color = 'var(--MainColor)';
            }
        }
    }

    applyFilterBtn.addEventListener('click', function() {
        const selectedCategories = getSelectedValues('category[]');
        const selectedBrands = getSelectedValues('brand[]');
        const selectedPlatforms = getSelectedValues('platform[]');
        const selectedTechnologies = getSelectedValues('technology[]');
        
        const sliderRangeValues = $('.slider-range-price').slider('values');
        const minValue = sliderRangeValues[0];
        const maxValue = sliderRangeValues[1];
        if (!(selectedCategories.length || selectedBrands.length || selectedPlatforms.length || selectedTechnologies.length)) {
            event.preventDefault(); 
        } else {
        
            if (selectedCategories.length > 0) {
                filterUrl += 'CategoryIDs=' + selectedCategories.join(',') + '&';
            }
            
            if (selectedBrands.length > 0) {
                filterUrl += 'BrandIDs=' + selectedBrands.join(',') + '&';
            }
    
            if (selectedPlatforms.length > 0) {
                filterUrl += 'PlatformIDs=' + selectedPlatforms.join(',') + '&';
            }
    
            if (selectedTechnologies.length > 0) {
                filterUrl += 'TechnologyIDs=' + selectedTechnologies.join(',') + '&';
            }

            filterUrl += 'PriceBetween=' + minValue + ',' + maxValue;
            window.location.href = filterUrl;
        }
    });

    resetBtn.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            updateBorder(checkbox); 
            if (checkbox.closest('.CategoryCheckBox')) {
                checkbox.closest('.CategoryCheckBox').style.color = 'black';
                checkbox.closest('.CategoryCheckBox').classList.remove('CheckedBefore');
            }
        });
    });


    function getSelectedValues(name) {
        const selectedValues = [];
        const checkboxes = document.querySelectorAll('input[name="' + name + '"]:checked');
        checkboxes.forEach(function(checkbox) {
            selectedValues.push(checkbox.value);
        });
        return selectedValues;
    }
});