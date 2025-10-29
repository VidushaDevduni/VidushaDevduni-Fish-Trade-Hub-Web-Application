<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// ✅ AUTO DELETE products older than 15 minutes
$delete_expired = $conn->prepare("DELETE FROM products WHERE TIMESTAMPDIFF(MINUTE, created_at, NOW()) > 15");
$delete_expired->execute();

include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Trade Hub - Fish Products</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Fish Products</h1>
        <p>Welcome to Fish Trade Hub!</p>
        <span><a href="home.php">Home</a> <i class="bx bx-right-arrow-alt"></i> Fish Products</span>
    </div>
</div>

<!-- Search Bar -->
<div class="search-container" style="text-align: center; margin: 20px;">
    <form action="" method="get">
        <input type="text" name="search" placeholder="Search by fish type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" style="padding: 8px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
        <div><button type="submit" class="btn">Search</button></div>
    </form>
</div>

<br>
<div class="products">
    <div class="heading">
        <?php if (isset($_GET['search']) && !empty(trim($_GET['search']))) : ?>
            <h1>Search Results</h1>
        <?php else : ?>
            <h1>All Fish Types</h1>
        <?php endif; ?>
    </div>

    <div class="box-container">
        <?php
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $search_term = "%" . trim($_GET['search']) . "%";
            $select_products = $conn->prepare("SELECT * FROM products WHERE status = ? AND fish_type LIKE ?");
            $select_products->execute(['active', $search_term]);
        } else {
            $select_products = $conn->prepare("SELECT * FROM products WHERE status = ?");
            $select_products->execute(['active']);
        }

        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                $available_kg = (int)$fetch_products['fish_weight'];
        ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
            <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Fish Image">

            <div class="content">
                <div class="button">
                    <h3 class="name"><?= htmlspecialchars($fetch_products['fish_type']); ?></h3>
                </div>

                <p class="arrival"><strong>Arrival Time:</strong> 
                    <?= isset($fetch_products['arrival_time']) ? date("d M Y, h:i A", strtotime($fetch_products['arrival_time'])) : 'N/A'; ?>
                </p>

                <p class="place"><strong>Arrival Place:</strong> 
                    <?= isset($fetch_products['arrival_place']) ? htmlspecialchars($fetch_products['arrival_place']) : 'N/A'; ?>
                </p>

                <p class="price"><strong>Price:</strong> Rs <?= isset($fetch_products['price']) ? number_format($fetch_products['price'], 2) : '0.00'; ?></p>

                <p class="weight"><strong>Available:</strong> <?= $available_kg > 0 ? $available_kg . ' kg' : '<span style="color:red;">Out of Stock</span>'; ?></p>

                <p class="detail"><strong>Details:</strong> <?= isset($fetch_products['details']) ? htmlspecialchars($fetch_products['details']) : 'No details available.'; ?></p>

                <?php if ($available_kg > 0): ?>
                <div class="input-field">
                    <label><strong>Enter weight (kg):</strong></label>
                    <input type="number" name="qty" required min="1" max="<?= $available_kg; ?>" value="1" class="qty" style="color: black;">
                </div>

                <div class="flex-btn">
                    <a href="#" class="btn buy-now" data-id="<?= $fetch_products['id']; ?>">Buy</a>
                    <a href="reviews.php" class="btn">Reviews</a>
                </div>
                <?php else: ?>
                    <div class="out-of-stock">This product is currently out of stock.</div>
                <?php endif; ?>

                <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
            </div>
        </form>
        <?php
            }
        } else {
            echo '<div class="empty"><p>No products found.</p></div>';
        }
        ?>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

<script>
    document.querySelectorAll('.buy-now').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            const qtyInput = this.closest('form').querySelector('.qty');
            const qty = qtyInput ? qtyInput.value : 1;
            window.location.href = `checkout.php?get_id=${productId}&qty=${qty}`;
        });
    });
</script>

</body>
</html>
