<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '1';
}

if (isset($_POST['send_message'])) {
    if ($user_id != '') {

        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $subject = $_POST['subject'];
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);

        $message = $_POST['message'];
        $message = filter_var($message, FILTER_SANITIZE_STRING);

        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);

        if ($verify_message->rowCount() > 0) {
            $warning_msg[] = 'Message already exists';
        } else {
            $insert_message = $conn->prepare("INSERT INTO `message` (id, user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);

            $success_msg[] = 'Message inserted successfully';
        }
    } else {
        $warning_msg[] = 'Please login first';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Trade Hub Contact Us Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
         .box {
            background-color: white;
        }
    </style>
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Contact Us</h1>
        <p>Welcome to Fish Trade Hub!<br></p>
        <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Contact</span>
    </div>
</div>

<div class="service">
    <div class="heading">
        <h1>Our Service</h1>
        <p></p>
    </div>
</div>
<div class="form-container">
    <form action="" method="post" class="register">
        <div class="input-field">
            <label>Name</label>
            <input type="text" name="name" required placeholder="Enter your name" class="box">
        </div>
        <div class="input-field">
            <label>Email</label>
            <input type="email" name="email" required placeholder="Enter your email" class="box">
        </div>
        <div class="input-field">
            <label>Subject</label>
            <input type="text" name="subject" required placeholder="Enter subject" class="box">
        </div>
        <div class="input-field">
            <label>Message</label>
            <textarea name="message" cols="30" rows="10" required placeholder="Enter your message" class="box"></textarea>
        </div>
        <button type="submit" name="send_message" class="btn">Send Message</button>
    </form>
</div>
<div class="address">
    <div class="heading">
        <h1 style="color: #c4e2e0;;">Our Contact Details</h1>
    </div>
    <div class="box-container">
        <div class="box" style="background-color: white;">
            <i class="bx bxs-map-alt"></i>
            <div>
                <h4>Address</h4>
                <p>1093 Colombo, Main Road,Sri Lanka</p>
            </div>
        </div>
        <div class="box" style="background-color: white;">
            <i class="bx bxs-phone-incoming"></i>
            <div>
                <h4>Phone Number</h4>
                <p>09823456</p>
            </div>
        </div>
        <div class="box" style="background-color: white;">
            <i class="bx bxs-envelope"></i>
            <div>
                <h4>Email</h4>
                <p>fishtrade@gmail.com</p>
            </div>
        </div>
    </div>
</div>

<?php 
// Include footer component
include 'components/footer.php'; 

// Show success messages if available
if (!empty($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>
            setTimeout(() => {
                swal({
                    title: 'Success',
                    text: '$msg',
                    icon: 'success',
                });
            }, 500);
        </script>";
    }
}

// Show warning messages if available
if (!empty($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>
            setTimeout(() => {
                swal({
                    title: 'Warning',
                    text: '$msg',
                    icon: 'warning',
                });
            }, 500);
        </script>";
    }
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>

</body>
</html>
