<?php
require_once('vendor/autoload.php'); // Make sure to include Stripe PHP library

\Stripe\Stripe::setApiKey('sk_test_51Nd8nNIaGLsjBdhfxN5HYVXlKNTnANIyoJxsVjnvddcLosbj9WDENOmm5eienpxxYwkLw5gYxN2ndhPVkb8izbUS005NOXh24X'); // Set your Stripe Secret Key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Token is created using Stripe.js or Checkout!
    // Get the payment token submitted by the form:
    $token = $_POST['stripeToken'];

    // Create a charge:
    try {
        $charge = \Stripe\Charge::create([
            'amount' => 1000, // Amount in cents
            'currency' => 'usd',
            'description' => 'Example Charge',
            'source' => $token,
        ]);

        // Payment successful
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
            data-key="YOUR_PUBLISHABLE_KEY"
            data-amount="1000" 
            data-name="Stripe Payment Example"
            data-description="Example charge"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto">
        </script>
    </form>
</body>
</html>
