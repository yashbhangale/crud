<?php
// Establish the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registerinfo";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    // Handle the uploaded image
    $imageData = null;
    $imageType = null;

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['profileImage']['tmp_name'];
        $imageType = $_FILES['profileImage']['type'];

        // Get the contents of the image file
        $imageData = file_get_contents($imageTmpPath);
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO users (firstName, lastName, email, password, phoneNumber, address, dob, profileImage, imageType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $mysqli->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $password, $phoneNumber, $address, $dob, $imageData, $imageType);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful!
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
    
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
    
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    
        label {
            display: block;
            margin-bottom: 10px;
        }
    
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
        }
    
        button[type="submit"] {
            background-color: red;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    
        .image-preview {
            text-align: center;
            margin-bottom: 20px;
        }
    
        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
    
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>
            
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>
            
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required>
            
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
            
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>

            <label for="profileImage">Profile Image</label>
            <input type="file" id="profileImage" name="profileImage" accept="image/*">
            <div class="image-preview">
                <img id="imagePreview" src="" alt="Image Preview">
            </div>
            
            <button type="submit">Register</button>
        </form>
    </div>

    <script>
        // Display image preview
        const profileImageInput = document.getElementById('profileImage');
        const imagePreview = document.getElementById('imagePreview');

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    imagePreview.src = reader.result;
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
            }
        });
    </script>
</body>
</html>
