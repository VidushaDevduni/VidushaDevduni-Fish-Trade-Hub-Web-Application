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
    <title>Fish Trade Hub about us page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  

</head>
<body>
<?php include 'components/user_header.php'; ?>
<div class="banner">
    <div class="detail">
        <h1>About us</h1>
     
        <span><a href="home1.php">Home</a><i class="bx bx-right-arrow-alt"></i>About us</span>
    </div>
</div>
<div class="mission" style="background-image: url('image/wallpaper3.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; padding: 50px 0;">

    <div class="box-container">
        <div class="box">
        <div class="heading">
            <h1 style="color: #82ccdb;">Our mission</h1>
            <img src="image/fish4.png">
        </div>
        <div class="detail">
            <div class="img-box">
            <img src="image/start.png">
            </div>
            <div>
                <h2 style="color: #9eebee;">Real-Time Updates with Images:</h2>
                <p style="color: white;">Fishermen share catch details and images for transparency, allowing customers to verify freshness.</p>
            </div>
        </div>
        <div class="detail">
            <div class="img-box">
            <img src="image/start.png">
            </div>
            <div>
            <h2 style="color: #9eebee;">Health & Safety Compliance: </h2>
            <p style="color: white;">Fish are handled according to strict standards, ensuring safe and high-quality products for customers.</p>
            </div>
        </div>
        <div class="detail">
            <div class="img-box">
            <img src="image/start.png">
            </div>
            <div>
            <h2 style="color: #9eebee;">Customer Reviews: </h2>
            <p style="color: white;">Feedback and refund options ensure accountability and continuous quality improvement.</p>
            </div>
        </div>
        <div class="detail">
            <div class="img-box">
            <img src="image/start.png">
            </div>
            <div>
            <h2 style="color: #9eebee;">Health & Safety Compliance: </h2>
            <p style="color: white;">Fish are handled according to strict standards, ensuring safe and high-quality products for customers.</p>
            </div>
        </div>
        </div>
        <div class="box">
                <img src="image/deliver.png" alt="" class="img">
            </div>
    </div>
</div>






<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

</body>
</html>