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

// Handling form submission
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Check if OTP matches for the given email
    $sql = "SELECT * FROM users WHERE email = '$email' AND otp = '$otp'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // OTP matched, perform successful login action
        echo "OTP verification successful. You are logged in!";
    } else {
        echo "Invalid OTP. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body>
    <h2>OTP Verification</h2>
    <form method="POST" action="">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <input type="text" name="otp" placeholder="Enter OTP" required><br><br>
        <input type="submit" name="submit" value="Verify OTP">
    </form>
</body>
</html>
