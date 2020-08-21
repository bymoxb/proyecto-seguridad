<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cliente</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body class="container">
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=ARVTpAWROXRPTt38TvxIdgp1RC2cYIFtRZpfmKIjErjySoJ5JRqa4mNPAEO8-KOKtPcH7dELpo8yyO3e&debug=true">
        // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script> -->

    <!-- https://developer.paypal.com/docs/archive/checkout/integrate/# -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">PAYPAL INTEGRACIÓN CLIENTE</h4>
        </div>
        <div class="card-body">
            <!-- <img src="https://i.pinimg.com/originals/a4/84/c7/a484c71e796fa82d5b40a94cfac36b7d.jpg"> -->
            <!-- <h1 class="card-title pricing-card-title">$10.00</small></h1> -->
        </div>
        <div id="paypal-button"></div>
    </div>

    <pre id="json"></pre>

    <script>
        paypal.Button.render({
            // Configure environment
            env: 'sandbox',
            client: {
                sandbox: 'ARVTpAWROXRPTt38TvxIdgp1RC2cYIFtRZpfmKIjErjySoJ5JRqa4mNPAEO8-KOKtPcH7dELpo8yyO3e',
                production: 'demo_production_client_id'
            },
            // Customize button (optional)
            locale: 'es_ES',
            style: {
                size: 'large',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: '30.11',
                            currency: 'USD',
                            details: {
                                subtotal: '30.00',
                                tax: '0.07',
                                shipping: '0.03',
                                handling_fee: '1.00',
                                shipping_discount: '-1.00',
                                insurance: '0.01'
                            }
                        },
                        description: 'The payment transaction description.',
                        custom: '90048630024435',
                        //invoice_number: '12345', Insert a unique invoice number
                        payment_options: {
                            allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
                        },
                        soft_descriptor: 'ECHI5786786',
                        item_list: {
                            items: [{
                                    name: 'hat',
                                    description: 'Brown hat.',
                                    quantity: '5',
                                    price: '3',
                                    tax: '0.01',
                                    sku: '1',
                                    currency: 'USD'
                                },
                                {
                                    name: 'handbag',
                                    description: 'Black handbag.',
                                    quantity: '1',
                                    price: '15',
                                    tax: '0.02',
                                    sku: 'product34',
                                    currency: 'USD'
                                }
                            ],
                            shipping_address: {
                                recipient_name: 'Brian Robinson',
                                line1: '4th Floor',
                                line2: 'Unit #34',
                                city: 'San Jose',
                                country_code: 'US',
                                postal_code: '95131',
                                phone: '011862212345678',
                                state: 'CA'
                            }
                        }
                    }],
                    note_to_payer: 'Contact us for any questions on your order.'
                });
            },
            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function(details) {
                    // Show a confirmation message to the buyer
                    document.getElementById("json").innerHTML = JSON.stringify(details, undefined, 2);
                    // window.alert('Thank you for your purchase!');
                });
            }
        }, '#paypal-button');
    </script>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '10.00'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    document.getElementById("json").innerHTML = JSON.stringify(details, undefined, 2);
                });
            }
        }).render('#paypal-button-container');
        // This function displays Smart Payment Buttons on your web page.
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
