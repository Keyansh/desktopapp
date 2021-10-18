<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Consort hardware order payment with Stripe</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!--
        <link rel="stylesheet" type="text/css" href="css/style.css">
        -->
        <style type="text/css">
            body{ font-family: sans-serif; background: #f9f9f9;}


            .decoration {
                border: 1px solid #ddd;
                background: #1f548a;
                padding: 45px;
                margin: 0 auto;
                color: #fff;
                text-align: center;
            }
        </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        .spacer {
            margin-bottom: 24px;
        }

        /**
         * The CSS shown here will not be introduced in the Quickstart guide, but shows
         * how you can use CSS to style your Element's container.
         */
        .StripeElement {
            background-color: white;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid #ccd0d2;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        #card-errors {
            color: #fa755a;
        }
        #checkout-button {
            border: 0;
            margin: 15px;
            font-size: 25px;
            cursor: pointer;
            background: #fff;
        }
        #checkout-button:hover{
            background: #89c341;
            color: #fff;
        }
    </style>

</head>
<body>
<section class="payment-form">
    <div class="container">
        <div class="row">
            <div class="col-md-8 decoration">
                <h1 class="text-center">Please click on proceed to redirect to payment ... </h1>
                <button id="checkout-button">Proceed</button>                
            </div>
        </div>
    </div>
</section>

<script>

(function(){
        // Create a Stripe client
        //var stripe = Stripe('pk_test_RZfDvlorjLWSS2h7aS3jJlNb00clC0QC8G');
        var stripe = Stripe('<?= DWS_STRIPE_PUBLISHABLE_KEY ?>');    
        var CHECKOUT_SESSION_ID = "<?= $session->id; ?>";
        var checkoutBtn = document.getElementById('checkout-button');
        checkoutBtn.addEventListener('click', function() {
            stripe.redirectToCheckout({
                // Make the id field from the Checkout Session creation API response
                // available to this file, so you can provide it as parameter here
                // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
                sessionId: CHECKOUT_SESSION_ID
                }).then(function (result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, display the localized error message to your customer
                // using `result.error.message`.
                });
            });
    })();
    </script>
    </body>
</html>
