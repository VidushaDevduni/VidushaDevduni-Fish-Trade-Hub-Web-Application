<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// Save order
if (isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address_type = $_POST['address_type'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $pin = $_POST['pin'];

    $grand_total = 0;

    if (isset($_GET['get_id']) && isset($_GET['qty'])) {
        $get_id = $_GET['get_id'];
        $qty = max(1, min((int)$_GET['qty'], 99)); // Validate qty

        // Get selected product details
        $select_product = $conn->prepare("SELECT price, fish_weight FROM products WHERE id = ?");
        $select_product->execute([$get_id]);
        $product = $select_product->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            if ($product['fish_weight'] >= $qty) {
                $grand_total = $product['price'] * $qty;

                // Insert the order
                $insert_order = $conn->prepare("INSERT INTO customer_orders 
                    (user_id, name, number, email, method, address_type, flat, street, city, country, pin, total_price)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([
                    $user_id, $name, $number, $email, $method, $address_type,
                    $flat, $street, $city, $country, $pin, $grand_total
                ]);

                // Subtract ordered quantity from stock
                $update_qty = $conn->prepare("UPDATE products SET fish_weight = fish_weight - ? WHERE id = ?");
                $update_qty->execute([$qty, $get_id]);

                echo "<script>
                    setTimeout(() => {
                        swal({
                            title: 'Order Placed!',
                            text: 'Your order was successfully placed.',
                            icon: 'success',
                        }).then(() => {
                            window.location.href = 'home.php';
                        });
                    }, 500);
                </script>";
            } else {
                echo "<script>alert('Not enough stock. Only {$product['fish_weight']} kg available.');
                window.location.href = 'menu.php';</script>";
                exit;
            }
        }
    } else {
        // Handle cart-based orders
        $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_product = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $select_product->execute([$fetch_cart['product_id']]);
            $product = $select_product->fetch(PDO::FETCH_ASSOC);
            $grand_total += $product['price'] * $fetch_cart['qty'];
        }

        $insert_order = $conn->prepare("INSERT INTO customer_orders 
            (user_id, name, number, email, method, address_type, flat, street, city, country, pin, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_order->execute([
            $user_id, $name, $number, $email, $method, $address_type,
            $flat, $street, $city, $country, $pin, $grand_total
        ]);

        echo "<script>
            setTimeout(() => {
                swal({
                    title: 'Order Placed!',
                    text: 'Your order was successfully placed.',
                    icon: 'success',
                }).then(() => {
                    window.location.href = 'home.php';
                });
            }, 500);
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fish Trade Hub Checkout Page</title>
    <link rel="stylesheet" href="css/checkout.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Checkout</h1>
        <p>Welcome to Fish Trade Hub!</p>
        <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Checkout</span>
    </div>
</div>

<div class="checkout">
    <div class="heading">
        <h1>Checkout Summary</h1>
    </div>
            <div class="summary">
            <h3>Total Detail</h3>
            <div class="box-container">
                <?php
                $grand_total = 0;
                if (isset($_GET['get_id']) && isset($_GET['qty'])) {
                    $get_id = $_GET['get_id'];
                    $qty = max(1, min((int)$_GET['qty'], 99));

                    $select_get = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $select_get->execute([$get_id]);

                    while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                        $sub_total = $fetch_get['price'] * $qty;
                        $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="uploaded_files/<?= $fetch_get['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_get['fish_type']; ?></h3>
                                <p class="price">Rs.<?= number_format($fetch_get['price'], 2); ?> x <?= $qty; ?> = Rs.<?= number_format($sub_total, 2); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    <div class="row">
        <form action="" method="post" class="register">
            <h3>Billing details</h3>
            <div class="flex">
                <div class="box">
                    <div class="input-field"><p>Your Name</p><input type="text" name="name" required></div>
                    <div class="input-field"><p>Your Number</p><input type="number" name="number" required></div>
                    <div class="input-field"><p>Your Email</p><input type="email" name="email" required></div>
                    <div class="input-field"><p>Payment Method</p>
                        <select name="method">
                            <option value="cash on delivery">Cash on Delivery</option>
                            <option value="credit or debit card">Credit or Debit Card</option>
                            <option value="net banking">Net Banking</option>
                            <option value="UPI or RuPay">UPI or RuPay</option>
                            <option value="paytm">Paytm</option>
                        </select>
                    </div>
                    <div class="input-field"><p>How would you like to get your fish?</p>
                        <select name="address_type">
                            <option value="home">Home Delivery</option>
                            <option value="office">I'll Pick Up at the Harbor</option>
                        </select>
                    </div>
                </div>
                <div class="box">
                    <div class="input-field"><p>Address Line 1</p><input type="text" name="flat" required></div>
                    <div class="input-field"><p>Address Line 2</p><input type="text" name="street" required></div>
                    <div class="input-field"><p>City Name</p><input type="text" name="city" required></div>
                    <div class="input-field"><p>fish type</p><input type="text" name="country" required></div>
                    <div class="input-field"><p>Pincode</p><input type="number" name="pin" required></div>
                </div>
            </div>
            <button type="submit" name="place_order" class="btn">Place Order</button>
        </form>


    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
</body>
</html>
