<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Trade Hub Cart Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Cart</h1>
        <p>Welcome to Fish Trade Hub!<br></p>
        <span><a href="home1.php">Home</a><i class="bx bx-right-arrow-alt"></i>Cart</span>
    </div>
</div>

<div class="products">
    <div class="heading">
        <h1>My Cart</h1>
    </div>
    <div class="box-container">
        <?php
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                    $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $select_products->execute([$fetch_cart['product_id']]);

                    if ($select_products->rowCount() > 0){
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                        $grand_total += $fetch_cart['price'] * $fetch_cart['qty'];
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                <div class="content">
                    <h3 class="name"><?= $fetch_products['fish_type']; ?></h3>
                    <p class="price">Rs <?= number_format($fetch_products['price'], 2); ?></p>
                    <p class="qty">Quantity: <?= $fetch_cart['qty']; ?></p>
                    <p class="total">Total: Rs <?= number_format($fetch_cart['price'] * $fetch_cart['qty'], 2); ?></p>
                </div>
            </form>
            <?php
                    }
                }
            } else {
                echo '<div class="empty"><p>Your cart is empty!</p></div>';
            }
        ?>
    </div>
    <div class="grand-total">
        <p>Grand Total: Rs <?= number_format($grand_total, 2); ?></p>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

</body>
</html>