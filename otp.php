<?php
// Database connection settings
$host = "localhost";
$username = "root";
$password = "";
$dbname = "registerinfo";

// Establishing connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to send OTP via email
function sendOTP($email, $otp) {
    // Configure your email settings
    $from = "your_email@example.com";
    $subject = "OTP for Login";
    $message = "Your OTP for login is: $otp";

    // Send email
    mail($email, $subject, $message, "From: $from");
}

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Handling form submission
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $otp = generateOTP();
        // Store the OTP in the database
        $sql = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
        mysqli_query($conn, $sql);

        // Send OTP via email
        sendOTP($email, $otp);

        // Redirect to OTP verification page
        header("Location: otpverification.php?email=$email");
        exit();
    } else {
        echo "Invalid email or password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login Page</h2>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
