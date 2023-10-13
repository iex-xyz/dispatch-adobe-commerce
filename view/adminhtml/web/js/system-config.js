require(["jquery"], function ($) {
    $(document).ready(function () {
        function toggleClientKeyField() {
            var paymentMethodField = $("#sales_channel_general_payment_method").val();
            var clientKeyField = $("#row_sales_channel_general_payment_method_client_key");
            if (paymentMethodField && paymentMethodField.length > 1) {
                clientKeyField.show();
                console.log("show");
            } else {
                clientKeyField.hide();
            }
        }
        toggleClientKeyField();

        $("#sales_channel_general_payment_method").change(function () {
            toggleClientKeyField();
        });
    });
});
