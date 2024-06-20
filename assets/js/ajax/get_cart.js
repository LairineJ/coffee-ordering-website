$(document).ready(function () {
  // Use AJAX to fetch and insert the content from get_cart.php (with controls)
  $.ajax({
    url: '../pages/get_cart.php',
    method: 'GET',
    success: function (response) {
      // Insert the response into the cart container
      $('#cart-conn').html(response);
    },
    error: function () {
      console.error('Failed to load cart content.');
    }
  });

  // Use AJAX to fetch and insert the content from get_cart.php (without quantity box and remove button)
  $.ajax({
    url: '../pages/get_cart.php?exclude_controls=true',
    method: 'GET',
    success: function (response) {
      // Insert the response into the cart container
      $('#checkout-conn').html(response);
    },
    error: function () {
      console.error('Failed to load cart content.');
    }
  });
});
