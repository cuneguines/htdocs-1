<?php
require_once('vendor/autoload.php'); // Make sure to include Stripe PHP library

\Stripe\Stripe::setApiKey('sk_test_51Nd8nNIaGLsjBdhfxN5HYVXlKNTnANIyoJxsVjnvddcLosbj9WDENOmm5eienpxxYwkLw5gYxN2ndhPVkb8izbUS005NOXh24X'); // Set your Stripe Secret Key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Token is created using Stripe.js or Checkout!
    // Get the payment token submitted by the form:
    $token = $_POST['stripeToken'];
    $email = $_POST['email'];
    // Create a charge:
    try {
        $charge = \Stripe\Charge::create([
            'amount' => 100, // Amount in cents
            'currency' => 'usd',
            'description' => 'Example Charge',
            'source' => $token,
            'receipt_email' => $email,
        ]);

        // Payment successful
        echo $chargeemail=$charge->reciept_email;
        echo $chargeId = $charge->id;
        echo $amount = $charge->amount;
        echo $currency = $charge->currency;
        echo $paymentStatus = $charge->status;
        echo "Payment successful! Charge ID: " . $charge->id;
    } catch (\Stripe\Exception\CardException $e) {
        // Payment failed
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment Example</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Stripe Payment Example</h1>
    <form action="" method="POST">
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_51Nd8nNIaGLsjBdhfGGo97LrpHjV1CvdSfeEVyyRNeHjZa3lw0HXmAmPqzICpBSN4Fduv68T5ha2lC8wVSMewsFED00tmvAOTKQ"
            data-amount="100" 
            data-name="Stripe Payment Example"
            data-description="Example charge"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto">



        </script>
        </form>
        <script>
            //Inside your form submission event listener
form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Collect email and other data
    var email = document.getElementById('email').value;

    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            stripeTokenHandler(result.token, email); // Pass email to handler
        }
    });
});
            </script>
    
</body>
</html>
