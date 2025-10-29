<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Trade Hub Home page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'; ?>



<div class="slider-container">
    <div class="slider">
        <div class="sliderBox active">
        <?php if (!empty($user_id)): ?>
    <div class="login-register-section">
       
        <div class="flex-btn">
    <a href="register.php" class="btn">Register</a>  <!-- Left Button -->
    <a href="login.php" class="btn">Login</a>  <!-- Right Button -->
</div>
    </div>
<?php endif; ?>
<div class="textBox">
    <h1>
        <span class="welcome-text">Welcome to Fish Trade Hub</span>
        <span class="sub-text">Where Freshness Meets Your Plate!
            <br>
           <h6> At Fish Trade Hub, we connect local fishermen with seafood lovers across Sri Lanka. 
            <br>Enjoy instant updates on the freshest catch,
            book your orders seamlessly online, and experience the joy of quality seafood delivered fresh from the coast.</h6>
        </span>
       
    </h1>
    <a href="menu.php" class="btn">Shop now</a>
</div>
            <div class="imgBox">
                <img src="image/wallpaper.jpg">
            </div>
        </div>
    </div>
</div>


<div class="service">
    <div class="box-container">
    <div class="box">
    <div class="icon">
        <div class="icon-box">
            <img src="image/service2.jpg" class="img1">
        </div>
    </div>
    <div class="detail">
        <h4>Fresh Catch</h4>
        <span>Guaranteed freshness</span>
    </div>
</div>

<div class="box">
    <div class="icon">
        <div class="icon-box">
            <img src="image/service3.png" class="img1">
        </div>
    </div>
    <div class="detail">
        <h4>Secure Payment</h4>
        <span>100% safe transactions</span>
    </div>
</div>



<div class="box">
    <div class="icon">
        <div class="icon-box">
            <img src="image/service4.jpg" class="img1">
        </div>
    </div>
    <div class="detail">
        <h4>Customer Support</h4>
        <span>24/7 assistance</span>
    </div>
</div>

    </div>
</div>

<div class="taste">
    <div class="heading">
        <span><h1>Benefits of Eating Fish</h1> </span>
        <h1></h1>
        <img src="image/fish1.png">
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/fish4.png">
            <div class="detail">
            <h2>Rich in Nutrients: </h2>
                <h3>Packed with high-quality protein, vitamins, and minerals.</h3>
               
            </div>
        </div>
        <div class="box">
        <img src="image/fish4.png">
            <div class="detail">
            <h2>Improved Mood:  </h2>
                <h3>Regular fish consumption is linked to reduced depression</h3>
               
            </div>
        </div>
        <div class="box">
            <img src="image/fish4.png">
            <div class="detail">
            <h2>Healthy Skin and Hair: </h2>
                <h3>Packed with high-quality protein, vitamins, and minerals.</h3>
               
            </div>
        </div>
        <div class="box">
        <img src="image/fish4.png">
            <div class="detail">
            <h2>Weight Management: </h2>
                <h3>Low in calories yet highly satisfying for weight control </h3>
               
            </div>
        </div>
        <div class="box">
            <img src="image/fish4.png">
            <div class="detail">
            <h2>Rich in Nutrients: </h2>
                <h3>Packed with high-quality protein, vitamins, and minerals.</h3>
               
            </div>
        </div>
        <div class="box">
        <img src="image/fish4.png">
            <div class="detail">
            <h2>Rich in Nutrients: </h2>
                <h3>Packed with high-quality protein, vitamins, and minerals.</h3>
               
            </div>
        </div>
        <div class="box">
            <img src="image/fish4.png">
            <div class="detail">
            <h2>Bone Health:.</h2>
                <h3>Vitamin D and calcium in fish strengthen bones</h3>
               
            </div>
        </div>
        <div class="box">
            <img src="image/fish4.png">
            <div class="detail">
            <h2>Heart Health: </h2>
                <h3>Omega-3 fatty acids help reduce the risk of heart disease.</h3>
               
            </div>
        </div>
    </div>
</div>

<div class="fish-container">
    <div class="overlay"></div>
    <div class="detail">
        <h1>Why Choose Fish Trade Hub?</h1>
       <h3>🐟 Freshness Guaranteed: Direct access to the latest catch straight from fishermen.<br>
📲 Instant Notifications: Be the first to know about fresh arrivals with SMS alerts.<br>
🛒 Easy Reservations: Book your desired fish quantity online hassle-free.<br>
🌊 Fishing Insights: Gain valuable information on fishing spots and sea weather.<br>
⭐ Quality Assurance: View fish images and customer reviews for confident purchases.</h3>
        <a href="menu.php" class="btn">Shop now</a>
    </div>
</div>

<div class="taste2">
    <div></div>
</div>

<?php include 'components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>