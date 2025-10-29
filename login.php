<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '1';
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        setcookie('users_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location:home.php');
    } else {
        $warning_msg = 'Incorrect email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Trade Hub Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Log in</h1>
        <p>Welcome to Fish Trade Hub!<br></p>
        <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Login</span>
    </div>
</div>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="login">
        <h3>Login Now</h3>
        <div class="input-field">
            <p>Your Email<span>*</span></p>
            <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
        </div>
        <div class="input-field">
            <p>Your Password<span>*</span></p>
            <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
        </div>
        <p class="link">Do not have an account? <a href="register.php">Register now</a></p>
        <input type="submit" name="submit" value="Login Now" class="btn">
    </form>
</div>

<?php 
// Include footer component
include 'components/footer.php'; 

// Show alert if there's a warning message
if (isset($warning_msg)) {
    echo "<script>
        setTimeout(() => {
            swal({
                title: 'Login Failed',
                text: '$warning_msg',
                icon: 'error',
            });
        }, 500);
    </script>";
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

</body>
</html>
