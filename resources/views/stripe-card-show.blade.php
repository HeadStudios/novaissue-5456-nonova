<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Page title</title>
    <meta charset="utf-8">
    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js">-->
    <script src="https://js.stripe.com/v3/"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="stylesheet" href="{{ asset('css/tailwind/tailwind.min.css') }}"> -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-tailwind.png') }}">

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    const gothere = async function() {
    const response = await fetch('/intenter',  { method: "POST" });
    const names = await response.json(); 
    //var clientSecret = names['client_secret'];
    console.log('Response is coming..');
    console.log(names['client_secret']);
    return names['client_secret'];
    }
    var clientSecret = gothere();
    clientSecret
    .then(result => result.data)
    .then(data => clientSecret);// rest of script
    console.log('Do you hear the wind calling?');
    console.log(clientSecret);
    </script>
  </head>
  <body class="antialiased bg-body text-body font-body">
  <form id="payment-form">
  <div id="card-element">
    <!-- Elements will create input elements here -->
  </div>

  <!-- We'll put the error messages in this element -->
  <div id="card-errors" role="alert"></div>

  <button id="submit">Submit Payment</button>
</form>
<script>
    // Set up Stripe.js and Elements to use in checkout form
var elements = stripe.elements();
var style = {
    base: {
      iconColor: '#c4f0ff',
      color: '#000',
      fontWeight: '500',
      fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
      fontSize: '16px',
      fontSmoothing: 'antialiased',
      ':-webkit-autofill': {
        color: '#fce883',
      },
      '::placeholder': {
        color: '#87BBFD',
      },
    },
    invalid: {
      iconColor: '#FFC7EE',
      color: '#FFC7EE',
    }
};

var card = elements.create("card", { style: style });
card.mount("#card-element");
card.on('change', ({error}) => {
  let displayError = document.getElementById('card-errors');
  if (error) {
    displayError.textContent = error.message;
  } else {
    displayError.textContent = '';
  }
});

var form = document.getElementById('payment-form');

form.addEventListener('submit', async function(ev) {
  ev.preventDefault();
  const response = await fetch('/intenter',  { method: "POST" });
    const names = await response.json(); 
    console.log(names['client_secret']);
    var clientSecret = names['client_secret'];
  // If the client secret was rendered server-side as a data-secret attribute
  // on the <form> element, you can retrieve it here by calling `form.dataset.secret`
  stripe.confirmCardPayment(clientSecret, {
    payment_method: {
      card: card,
      billing_details: {
        name: 'Jenny Rosen'
      }
    }
  }).then(function(result) {
    if (result.error) {
      // Show error to your customer (for example, insufficient funds)
      alert(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
        alert('We got your money!');
        // Show a success message to your customer
        // There's a risk of the customer closing the window before callback
        // execution. Set up a webhook or plugin to listen for the
        // payment_intent.succeeded event that handles any business critical
        // post-payment actions.
      }
    }
  });
});
</script>
  </body>
</html>

