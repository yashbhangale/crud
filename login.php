<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registerinfo";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitize($input) {
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = $conn->real_escape_string($input);
    return $input;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the form submission
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    // Query the database for the user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Valid email and password
        $row = $result->fetch_assoc();
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $phoneNumber = $row['phoneNumber'];
        $address = $row['address'];
        $dob = $row['dob'];
        $profileImage = $row['profileImage'];

        // Close the database connection
        $conn->close();

        // Display the user information on a separate page
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>User Information</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                }

                h1 {
                    text-align: center;
                }

                .user-info {
                    margin-top: 20px;
                    font-size: 16px;
                    line-height: 1.6;
                }

                .profile-image {
                    text-align: center;
                    margin-top: 20px;
                }

                .profile-image img {
                    max-width: 200px;
                    max-height: 200px;
                    border-radius: 50%;
                }

                .print-button {
                    text-align: center;
                    margin-top: 20px;
                }
            </style>
            <script>
                function printPage() {
                    window.print();
                }
            </script>
        </head>
        <body>
            <h1>User Information</h1>
            <div class='profile-image'>
                <img src='data:image/jpeg;base64," . base64_encode($profileImage) . "' alt='Profile Image'>
            </div>
            <div class='user-info'>
                <p><strong>Name:</strong> $firstName $lastName</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone Number:</strong> $phoneNumber</p>
                <p><strong>Address:</strong> $address</p>
                <p><strong>Date of Birth:</strong> $dob</p>
            </div>
            <div class='print-button'>
                <button onclick='printPage()'>Print</button>
            </div>
        </body>
        </html>";
        exit; // Stop further execution of the script
    } else {
        // Invalid email or password
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 100px;
        }

        h2 {
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 3px;
            border: 1px solid #cccccc;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #4caf50;
            color: #ffffff;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
        #password {
            width: 94%;
        }
        #email {
            width: 94%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login</button>
            <button type="button" onclick="window.location.href = 'register.php'" style="margin-top: 15px;">Register</button>
        </form>
    </div>
</body>
</html>

