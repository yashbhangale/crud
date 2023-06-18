<?php
session_start();

// Check if the admin is already logged in
if (!isset($_SESSION['admin'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Check if the user ID is provided in the URL
if (empty($_GET['id'])) {
    // User ID is missing, redirect to user list page
    header("Location: user_list.php");
    exit();
}

// Get the user ID from the URL
$userID = $_GET['id'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted user information
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    // Validate and update the user information in the database
    if (validateUserInformation($firstName, $lastName, $email, $phoneNumber, $address, $dob)) {
        updateUserInformation($userID, $firstName, $lastName, $email, $phoneNumber, $address, $dob);
        // Redirect to user list page
        header("Location: user_list.php");
        exit();
    }
}

// Retrieve the user information from the database
$user = getUserInformation($userID);

// Function to validate the user information
function validateUserInformation($firstName, $lastName, $email, $phoneNumber, $address, $dob)
{
    // Add your validation logic here
    // Return true if the information is valid, false otherwise
    return true;
}

// Function to update the user information in the database
function updateUserInformation($userID, $firstName, $lastName, $email, $phoneNumber, $address, $dob)
{
    // Add your database update logic here
}

// Function to retrieve the user information from the database
function getUserInformation($userID)
{
    // Add your database retrieval logic here
    // Return the user information as an associative array
    return [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john.doe@example.com',
        'phoneNumber' => '1234567890',
        'address' => '123 Main St, City',
        'dob' => '1990-01-01'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        h1 {
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

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: red;
            color: #ffffff;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
        }

        button[type="submit"]:hover {
            background-color: lightcoral;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit User</h1>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $userID); ?>">
        <div class="input-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $user['firstName']; ?>" required>
        </div>

        <div class="input-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $user['lastName']; ?>" required>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>

        <div class="input-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo $user['phoneNumber']; ?>" required>
        </div>

        <div class="input-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>
        </div>

        <div class="input-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required>
        </div>

        <button type="submit">Save</button>
    </form>
</div>

</body>
</html>
