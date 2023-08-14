<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment Example</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Stripe Payment Example</h1>
    <form action="charge.php" method="POST" id="payment-form">
        <div class="form-row">
            <label for="card-element">
                Credit or debit card
            </label>
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>

        <!-- Additional card details -->
        <div class="form-row">
            <label for="card-expiry">
                Expiration Date (MM/YY)
            </label>
            <div id="card-expiry">
                <input type="text" id="card-expiry-input" required>
            </div>
        </div>
        
        <div class="form-row">
            <label for="card-cvc">
                CVC
            </label>
            <div id="card-cvc">
                <input type="text" id="card-cvc-input" required>
            </div>
        </div>

        <button>Submit Payment</button>
    </form>

    <script>
        var stripe = Stripe('pk_test_51Nd8nNIaGLsjBdhfGGo97LrpHjV1CvdSfeEVyyRNeHjZa3lw0HXmAmPqzICpBSN4Fduv68T5ha2lC8wVSMewsFED00tmvAOTKQ');

        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
</body>
</html>
