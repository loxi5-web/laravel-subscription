<?php

use Loxi5\Subscription\Cashier;

Route::namespace('\Loxi5\Subscription\Http\Controllers')->group(function () {

    Route::name('webhooks.mollie.default')->post(
        Cashier::webhookUrl(),
        'WebhookController@handleWebhook'
    );

    Route::name('webhooks.mollie.first_payment')->post(
        Cashier::firstPaymentWebhookUrl(),
        'FirstPaymentWebhookController@handleWebhook'
    );

});
