define([
    'jquery',
    'underscore',
    'mage/validation',
], function ($) {
    'use strict';
    var dataForm = $('#guest-form');
    function main(config, element)
    {
        var $_guestOrderUrl = config.guestOrderUrl;
        $(document).on('click', '#subit-order', function (event) {
            event.preventDefault();
            if (dataForm.validation('isValid')) {
				var $orderNumber = $('#order_id').val();
				var param = 'order_id='+$orderNumber;
				$.ajax({
					showLoader: true,
					url: $_guestOrderUrl,
					data: param,
					type: "GET",
					dataType: 'json'
				}).done(function (data) {
					$('.result').children('.order-result').html(JSON.stringify(data.result, null, " "));
				});
			}
        });
    };
    return main;
});