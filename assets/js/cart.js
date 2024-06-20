
const popupCart = document.querySelector('#popup-cart');
const cartCont = document.querySelector('#cart-contt');

const popupCartCon = document.querySelector('#cart-conn');
const popupHistoryCon = document.querySelector('#history-conn');
const sumCon = document.querySelector('#summ-con');

const cartButton = document.querySelector('#cart-buttonn');
const historyButton = document.querySelector('#history-buttonn');

// Toggle cart
popupCart.addEventListener('click', () => {
    if (cartCont.style.display !== 'flex') {
        cartCont.style.display = 'flex';
    } else {
        cartCont.style.display = 'none';
    }
})

// Change the product quantity
$(document).ready(function () {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });

    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    // Initialize the quantity input on page load
    var $initialQuantity = $('#quantity');
    $initialQuantity.val(parseInt($initialQuantity.val()) || 1);

    // Add an event listener for the form submission
    $('form').submit(function (event) {
        // Ensure the quantity is updated before form submission
        var $input = $('#quantity');
        $input.val(parseInt($input.val()));
        return true;
    });
});


historyButton.addEventListener('click', () => {
    if (popupHistoryCon.style.display !== 'block') {
        popupHistoryCon.style.display = 'block';
        popupCartCon.style.display = 'none';
        historyButton.style.backgroundColor = '#1A120B';
        historyButton.style.color = '#ffffff';
        cartButton.style.backgroundColor = 'transparent';
        cartButton.style.color = '#1A120B';
        sumCon.style.display = 'none';
    }
});

cartButton.addEventListener('click', () => {
    if (popupCartCon.style.display !== 'block') {
        popupHistoryCon.style.display = 'none';
        popupCartCon.style.display = 'block';
        historyButton.style.backgroundColor = 'transparent';
        historyButton.style.color = '#1A120B';
        cartButton.style.backgroundColor = '#1A120B';
        cartButton.style.color = '#ffffff';
        sumCon.style.display = 'block';
    }
});
