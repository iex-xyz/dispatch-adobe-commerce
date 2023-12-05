require(["jquery"], function ($) {
    $(document).ready(function () {
        function toggleClientKeyField() {
            var paymentMethodField = $("#sales_channel_general_payment_method").val();
            var clientKeyField = $(
                "#row_sales_channel_general_payment_method_client_key"
            );
            if (paymentMethodField && paymentMethodField.length > 1) {
                clientKeyField.show();
            } else {
                clientKeyField.hide();
            }
        }
        toggleClientKeyField();

        $("#sales_channel_general_payment_method").change(function () {
            toggleClientKeyField();
        });

        // Scroll to selected category

        var multiselectField = $('#sales_channel_general_catalog_id');
        var selectedOption = multiselectField.find('option:selected');

        if (selectedOption.length > 0) {
            var multiselectHeight     = multiselectField.height();
            var selectedOptionOffset  = selectedOption.position().top;
            var halfMultiselectHeight = multiselectHeight / 2;
            var scrollToCenter        = selectedOptionOffset - halfMultiselectHeight;

            multiselectField.scrollTop(scrollToCenter);
        }
    });
});
