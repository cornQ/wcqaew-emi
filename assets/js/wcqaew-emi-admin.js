jQuery(document).ready(function ($) {
    // Initialize WP Color Picker with alpha
    $('.color-field').each(function () {
        $(this).wpColorPicker({
            defaultColor: false,
            palettes: true,
            mode: 'rgba', 
            alpha: true   
        });
    });

    // Toggle color fields by design mode
    function toggleColorFields() {
        if ($('#wcqaew_emi_design_mode').val() === 'custom') {
            $('.wcqaew-color-option').show();
        } else {
            $('.wcqaew-color-option').hide();
        }
    }

    // Toggle custom currency field
    function toggleCurrencyField() {
        if ($('#wcqaew_emi_currency_mode').val() === 'custom') {
            $('.wcqaew-currency-custom').show();
        } else {
            $('.wcqaew-currency-custom').hide();
        }
    }

    $('#wcqaew_emi_design_mode').on('change', toggleColorFields);
    $('#wcqaew_emi_currency_mode').on('change', toggleCurrencyField);

    // Run on page load
    toggleColorFields();
    toggleCurrencyField();
});