<?php
session_start();
include 'assets/connection.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Fetch categories for the navbar
if (isset($_GET['category'])) {
    $selectedCategory = mysqli_real_escape_string($conn, $_GET['category']);
} else {
    $selectedCategory = 'default_category';
}

if (isset($_GET['subcategory'])) {
    $subcategory = mysqli_real_escape_string($conn, $_GET['subcategory']);
} else {
    $subcategory = 'All Products';
}

$targetModal = isset($_SESSION['custEmail']) ? "#checkoutModal" : "#loginModal";

// Check if the user is logged in
if (isset($_SESSION['custEmail'])) {
    $custEmail = $_SESSION['custEmail'];

    // Retrieve the user's cart from the database
    $sql = "SELECT * FROM cart WHERE email = '$custEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cart'] = json_decode($row['cart_data'], true);
    }
    else{
        $_SESSION['cart'] = [];
    }
}

if (isset($_POST['clear'])) {
    // Clear the session cart
    $_SESSION['cart'] = [];

    // Check if the user is logged in
    if (isset($_SESSION['custEmail'])) {
        $custEmail = $_SESSION['custEmail'];

        // Delete the cart data from the database
        $sqlDelete = "DELETE FROM cart WHERE email = '$custEmail'";
        $conn->query($sqlDelete);
        unset($_SESSION['totalPrice']);
    }
}

if (isset($_POST['remove'])) {
    $prod_id = $_POST['prod_id'];

    // Remove the product from the session cart
    $index = array_search($prod_id, array_column($_SESSION['cart'], 'prod_id'));
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Check if the user is logged in
    if (isset($_SESSION['custEmail'])) {
        $custEmail = $_SESSION['custEmail'];

        // Fetch the existing cart data from the database
        $sqlSelect = "SELECT * FROM cart WHERE email = '$custEmail'";
        $result = $conn->query($sqlSelect);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existingCartData = json_decode($row['cart_data'], true);

            // Find the index of the product in the existing cart data
            $existingIndex = array_search($prod_id, array_column($existingCartData, 'prod_id'));

            // Remove the product from the existing cart data
            if ($existingIndex !== false) {
                unset($existingCartData[$existingIndex]);
                $existingCartData = array_values($existingCartData);

                // Update the cart data in the database
                $updatedCartData = json_encode($existingCartData);
                $sqlUpdate = "UPDATE cart SET cart_data = '$updatedCartData' WHERE email = '$custEmail'";
                $conn->query($sqlUpdate);
            }
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="icon" type="image/png" href="./assets/images/icon/logo.png">
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
     <script src="../assets/js/alert/alert.js"></script>
    <title>Cafe Haraya</title>

    <script>
        function updateShippingFee() {
            $.ajax({
                url: '../pages/get_cart_info.php',
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    // Update the shipping fee and total price in checkoutModal.php
                    $('#shippingFeeDisplayModal').html('₱' + response.shippingFee);
                    $('#subtotalDisplayModal').html('₱' + response.subtotal);
                    $('#totalPriceDisplayModal').html('₱' + response.totalPrice);

                    $('#shipFDisplay').html('₱' + response.shippingFee);
                    $('#subtotalDisplay').html('₱' + response.subtotal);
                    $('#totalPriceDisplay').html('₱' + response.totalPrice);

                    var subtotalValue = response.subtotal;
                    var shippingFeeValue = response.shippingFee;
                    var totalPriceValue = response.totalPrice;
                },
                error: function () {
                    console.error('Failed to update shipping fee and total price.');
                }
            });
        }

        function enableCheckoutButton() {
            $('#checkout').prop('disabled', false);
        }
    </script>

    
    
</head>

<body>
<div class="loader">
	<div class="cup">
		<div class="handle"></div>
	</div>
</div>
    <main>
        <div class="navbar d-flex justify-content-between align-items-center sticky-top">
            <div class="nav-item">
                <img src="./assets/images/icon/logo.png" class="logo" alt="" onclick="window.location.href='index.php'" style="cursor: pointer;">
            </div>
            <div class="nav-item">
                <?php 
                 $sql = "SELECT DISTINCT mc.* 
                        FROM main_categ mc
                        INNER JOIN sub_categ sc ON mc.m_categ_name = sc.m_categ_name
                        LEFT JOIN products p ON sc.s_categ_name = p.prod_categ
                        WHERE mc.m_categ_visibility = 'visible' AND p.prod_categ IS NOT NULL";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <a href="index.php?category=<?php echo $row['m_categ_name']; ?>" class="navbar-categ"><?php echo $row['m_categ_name']; ?></a>
                        <?php
                    }
                }
                ?>
                <span class="navbar-separator" style="margin: 0 10px; color: #000;">|</span>
                <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['custEmail'])) {
                            ?><span><?php echo isset($_SESSION['custEmail']) ? $_SESSION['custEmail'] : ''; ?></span>
                            <?php echo '<a class="navbar-categ" style="margin: 0;" onclick="logoutCustomer();">Logout</a>';
                    } else {
                        echo '<a class="navbar-categ" style="margin: 0;" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>';
                    }
                    ?>
                <button id="popup-cart"><span class="fas fa-cart-plus"></span></button>
            </div>
        </div>
        <div class="main-con">
            <div id="carouselControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="car-con">
                            <div class="car-img"><img src="./assets/images/icon/2.jpg">
                                <div class='carousel-caption'>
                                    <h5>Cafe Haraya</h5>
                                    <h1>Love at First Sip</h1><button type="button" onclick="window.location.href='index.php?category=Food'">Discover Flavors</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="car-con">
                            <div class="car-img"><img src="./assets/images/icon/1.jpg">
                                <div class='carousel-caption'>
                                    <h5>Cafe Haraya</h5>
                                    <h1>Enjoy Life Sip by Sip</h1><button type="button" onclick="window.location.href='index.php?category=Drink'">Discover Drinks</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            

            <!-- CATEGORIES -->
            <div class="categ-con d-flex" id="categContainer">
                <?php 
                $sql = "SELECT * FROM sub_categ WHERE s_categ_visibility = 'visible' AND m_categ_name = '$selectedCategory'";
                $result = $conn->query($sql);
                
                // Check if there are any categories
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()):
                ?>
                    <div class="categ-item-con d-flex flex-column justify-content-center align-items-center">
                        <a href="index.php?category=<?php echo $selectedCategory; ?>&subcategory=<?php echo $row['s_categ_name']; ?>" style="text-decoration: none; text-align: center;">
                            <div class="categ-circle">
                                 <img src="data:image/png;base64,<?php echo base64_encode($row['s_categ_img']); ?>" alt="<?php echo $row['s_categ_name']; ?>">
                            </div>
                            <div class="categ-name"><span><?php echo $row['s_categ_name']; ?></span></div>
                        </a>
                    </div>
                <?php
                    endwhile;
                } else{
                    $sql = "SELECT * FROM sub_categ WHERE s_categ_visibility = 'visible' AND m_categ_name != 'not selected'";
                    $result = $conn->query($sql);
                    
                    // Check if there are any categories
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()):
                    ?>
                        <div class="categ-item-con d-flex flex-column justify-content-center align-items-center">
                            <a href="index.php?subcategory=<?php echo $row['s_categ_name']; ?>" style="text-decoration: none; text-align: center;">
                                <div class="categ-circle">
                                    <img src="data:image/png;base64,<?php echo base64_encode($row['s_categ_img']); ?>" alt="<?php echo $row['s_categ_name']; ?>">
                                </div>
                                <div class="categ-name"><span><?php echo $row['s_categ_name']; ?></span></div>
                            </a>
                        </div>
                    <?php
                        endwhile;
                    }
                }
                ?>
            </div>

            <!-- PRODUCTS -->
            <div class="prodc-con">
                <h2><?php echo $subcategory ?></h2>
                <hr>
                <div class="container">
                    <?php 
                    $sql = "SELECT * FROM products WHERE prod_visibility = 'visible' AND prod_categ='$subcategory'";
                    $result = $conn->query($sql);
                    // Display products based on the selected category
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="card">
                                <div class="imgBx">
                                    <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" />'; ?>
                                </div>
                                <div class="contentBx">
                                    <p><?php echo $row['prod_name']; ?></p>
                                    <span>P<?php echo $row['prod_price']; ?></span>
                                    <div class="calories">
                                        <span><?php echo $row['prod_calo']; ?> calories</span>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $row['prod_id'] ?>">Buy Now</a>
                                </div>
                            </div>
                    <div class="modal fade" id="productModal_<?php echo $row['prod_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <?php include "./assets/php/modals/productModal.php" ?>
                    </div>
                    <?php
                        }
                    } elseif($result->num_rows == 0 && $subcategory != "All Products"){
                        ?>
                        <div style="display: flex;justify-content: center; align-items: center; height: 100%;">
                                <img src="assets/images/icon/no_product.png" style="display: flex; justify-content: center; align-items: center; height: 100%;">
                            </div>
                        </div>

                        <?php
                    }elseif($selectedCategory == "default_category"){
                    $sql = "SELECT * FROM products WHERE prod_visibility = 'visible'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="card">
                                <div class="imgBx">
                                    <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" />'; ?>
                                </div>
                                <div class="contentBx">
                                    <p><?php echo $row['prod_name']; ?></p>
                                    <span>P<?php echo $row['prod_price']; ?></span>
                                    <div class="calories">
                                        <span><?php echo $row['prod_calo']; ?> calories</span>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $row['prod_id'] ?>">Buy Now</a>
                                </div>
                            </div>
                    <div class="modal fade" id="productModal_<?php echo $row['prod_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <?php include "./assets/php/modals/productModal.php" ?>
                    </div>
                    <?php
                        }
                    }
                    }else{
                        $sql = "SELECT * FROM products WHERE prod_visibility = 'visible' AND prodM_Categ='$selectedCategory'";
                        $result = $conn->query($sql);
                        // Display products based on the selected category
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="card">
                                <div class="imgBx">
                                    <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" />'; ?>
                                </div>
                                <div class="contentBx">
                                    <p><?php echo $row['prod_name']; ?></p>
                                    <span>P<?php echo $row['prod_price']; ?></span>
                                    <div class="calories">
                                        <span><?php echo $row['prod_calo']; ?> calories</span>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $row['prod_id'] ?>">Buy Now</a>
                                </div>
                            </div>
                    <div class="modal fade" id="productModal_<?php echo $row['prod_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <?php include "./assets/php/modals/productModal.php" ?>
                    </div>
                    <?php
                            }
                    }else{
                        $sql = "SELECT * FROM products WHERE prod_visibility = 'visible'";
                        $result = $conn->query($sql);
                        // Display products based on the selected category
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="card">
                                <div class="imgBx">
                                    <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" />'; ?>
                                </div>
                                <div class="contentBx">
                                    <p><?php echo $row['prod_name']; ?></p>
                                    <span>P<?php echo $row['prod_price']; ?></span>
                                    <div class="calories">
                                        <span><?php echo $row['prod_calo']; ?> calories</span>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $row['prod_id'] ?>">Buy Now</a>
                                </div>
                            </div>
                    <div class="modal fade" id="productModal_<?php echo $row['prod_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <?php include "./assets/php/modals/productModal.php" ?>
                    </div>
                    <?php
                            }
                        }
                    }
                    }
                    ?>
                </div>
            </div>

            <div class="cart-cont shadow" id="cart-contt">
                <div class="cart-header-con">
                    <div class="cart-header1">
                        <h4><span class="fas fa-cart-plus"></span> Your Order</h4>
                        <div class="btn text-white" data-bs-toggle="modal" data-bs-target="#customerInfoModal"
                            style="background-color: #1A120B"><i class="fa-solid fa-user"></i></div>
                    </div>
                    <div class="cart-header2">
                        <button type="button" class="history-button" id="history-buttonn">History</button>
                        <button type="button" class="cart-button" id="cart-buttonn">Cart</button>
                    </div>
                </div>
                <div class="clearAll">
                    <form method="post">
                        <button type="submit" class="clearAllBtn" name="clear" id="clearAllBtn">Clear All</button>
                    </form>
                </div>
                <div class="cart-con h-100" id="cart-conn">
                    
				</div>
                <div class="history-con h-100" id="history-conn">
                    <div class="history-oder-con" id="history-oder-con">
                        <?php 
                        $history_ids = []; // Initialize an empty array to store history_ids

                        $sql = "SELECT * FROM history WHERE email = '$custEmail'";
                        $run = mysqli_query($conn, $sql);

                        if ($run->num_rows > 0) {
                            while ($row = $run->fetch_assoc()) {
                                $history_id = $row['history_id'];
                                $history_ids[] = $history_id; // Add history_id to the array
                                ?>
                                <div class='itemCard historyCard<?php echo $history_id ?>' data-bs-toggle="modal" data-bs-target="#historyModal_<?php echo $history_id ?>" style='display: flex; justify-content: space-between; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; cursor: pointer; height: fit-content;'>
                                    <div class='history-left-column'>
                                        <div class='history-item'>
                                            <?php echo $row['ordered_at']; ?>
                                        </div>
                                        <div class='history-status <?php echo strtolower($row['status']); ?>'>
                                            <?php echo $row['status']; ?>
                                        </div>
                                            <?php
                                        foreach (json_decode($row['cart_data'], true) as $product) {
                                            ?>
                                            <div class='history-prodname'>
                                                <?php echo $product['prod_name']; ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="history-total">
                                        <?php echo $row['totalPrice']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo 'Your history is empty.';
                        }
                        ?>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                <div class="summ-con" id="summ-con">
                    <hr>
                    <h3>Summary</h3>
                    <hr>
                    <div class="sub-total-con" id="cart-details">
                        <div class="sub-right">
                            <h6>Sub Total:</h6>
                            <h6>Delivery Fee:</h6>
                            <h6>Total Price:</h6>
                        </div>
                       <div class="sub-left" id="cartInfoContainer">
                            <div id="subDisplay">₱0.00</div>
                            <div id="shipFDisplay">₱0.00</div>
                            <div id="totPriDisplay">₱0.00</div>
                        </div>

                        <script>
                            $(document).ready(function () {
                            // Function to update cart information using AJAX
                            function updateCartInfo() {
                                $.ajax({
                                    url: './pages/get_cart_info.php',
                                    method: 'POST', // Change the method to POST since you're sending data
                                    dataType: 'json',
                                    success: function (response) {
                                        // Update the HTML with the received information
                                        $('#subDisplay').html('₱' + response.subtotal);
                                        $('#shipFDisplay').html('₱' + response.shippingFee);
                                        $('#totPriDisplay').html('₱' + response.totalPrice);

                                        // Add other elements as needed
                                    },
                                    error: function () {
                                        console.error('Failed to update cart information.');
                                    }
                                });
                            }

                            // Call the function initially and whenever you add an item to the cart
                            updateCartInfo();
                        });
                        </script>
                                                
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" name="checkoutBtn" data-bs-target="<?php echo $targetModal?>">
                            Checkout
                    </button>
                </div>
        </div>

    <!-- CHECKOUT -->
    <div class="modal fade" id="checkoutModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <?php include './assets/php/modals/checkoutModal.php';?>
    </div>

    <!-- LOGIN -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <?php include './assets/php/modals/loginModal.php';?>
    </div>

    <!-- REGISTRATION -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <?php include './assets/php/modals/registerModal.php';?>
    </div>

    <!-- LOCATION MODAL -->
    <div class="modal fade" id="locationModalContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <?php include './assets/php/modals/locationModal.php';?>
    </div>

    <!-- ACCOUNT MODAL -->
    <div class="modal fade" id="customerInfoModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <?php include './assets/php/modals/customerModal.php';?>
    </div>

    <?php
    foreach ($history_ids as $history_id) {
        ?>
        <div class="modal fade" id="historyModal_<?php echo $history_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <?php include './assets/php/modals/historyModal.php'; ?>
        </div>
        <?php
    }
    ?>

    <?php include './assets/php/extensions/session.php'; ?>
    <?php include "./pages/crudCustomer.php"; ?>
    <?php include "./pages/crudLocation.php"; ?>
    <?php include "./pages/crudOrder.php"; ?>
    <?php include "./pages/cart.php"; ?>
    </main>
    <?php include "./assets/php/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/cart.js"></script>
    <script src="./assets/js/ajax/get_cart.js"></script>
    
    <script src="app.js"></script>
    <script>
    $(document).ready(function () {
        $(".loader").fadeOut("slow");

        var prevLoc = "<?php echo $prevLoc; ?>";
        $('#checkoutInput').val(prevLoc);

        function updateLocation() {
            var newLocation = $('#checkoutInput').val();
            $.ajax({
                url: './pages/crudLocation.php',
                method: 'POST',
                data: { checkoutBtn: true, checkoutInput: newLocation },
                success: function (response) {
                    console.log('Response from server:', response);
                    console.log('Location updated successfully');
                },
                error: function () {
                    console.error('Failed to update location.');
                }
            });
        }

        // Event handler for #setLocationBtn
        $('#checkoutModal').on('click', '#setLocationBtn', function () {
            console.log("Button clicked");
            var newLocation = $('#checkoutInput').val();
            updateLocation(newLocation);
        });

        // Event handler for #history-buttonn
        $('#history-buttonn').click(function () {
            $('.clearAll').hide();
        });

        // Event handler for #cart-buttonn
        $('#cart-buttonn').click(function () {
            $('.clearAll').show();
        });
    });

</script>
</body>
</html>

<style>
    .history-left-column {
        flex-grow: 1; 
        padding: 10px; 
        box-sizing: border-box; 
    }

    .history-item {
        font-weight: bold; 
    }

    .history-prodname {
        margin-top: 5px; 
        font-size: .9rem;
        color: #808080;
    }

    .history-status {
        margin-top: 5px; 
        font-size: .8rem;
        font-style: italic;
    }

    .history-total {
        flex-shrink: 0; 
        padding: 10px; 
        box-sizing: border-box; 
        text-align: right; 
    }

    .history-status.completed {
        color: #65B741;
    }

    .history-status.pending {
        color: #FFB534;
    }

    .history-status.cancelled {
        color: #B31312;
    }
</style>