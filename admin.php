<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin'])) {
    // User is already logged in, retrieve and display user information
    if (isset($_GET['logout'])) {
        // Logout requested, destroy the session and redirect to login page
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_GET['edit'])) {
        // Edit user requested, redirect to edit page
        $userId = $_GET['edit'];
        header("Location: edit_user.php?id=$userId");
        exit();
    } elseif (isset($_GET['delete'])) {
        // Delete user requested, perform deletion
        $userId = $_GET['delete'];
        deleteUser($userId);
    } else {
        displayUserInformation();
        exit(); // Add this line to prevent further code execution
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the admin credentials
    if ($username === 'admin' && $password === 'admin') {
        // Set session variable to mark the admin as authenticated
        $_SESSION['admin'] = true;
        // Redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Invalid credentials
        $error = "Invalid username or password!";
    }
}

// Function to display user information
function displayUserInformation()
{
    // Add your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registerinfo";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Retrieve the user data from the database
    $sql = "SELECT id, firstName, lastName, email, phoneNumber, address, dob, profileImage FROM users";
    $result = $mysqli->query($sql);

    // Display the user information
    echo "<!DOCTYPE html>
        <html>
        <head>
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

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                th, td {
                    padding: 10px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }

                th {
                    background-color: #f2f2f2;
                }

                .logout-btn {
                    display: flex;
                    justify-content: center;
                    margin-top: 20px;
                }
                @media (max-width: 768px) {
                    table {
                        display: block;
                        overflow-x: auto;
                        white-space: nowrap;
                    }
        
                    th, td {
                        display: inline-block;
                        width: auto;
                    }
                }
            </style>
        </head>
        <body>
            <h1>User Information</h1>";

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>Profile Image</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            // Display other user information
            echo "<td>" . $row['firstName'] . "</td>";
            echo "<td>" . $row['lastName'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phoneNumber'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['dob'] . "</td>";

            // Display the profile image
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['profileImage']) . "'></td>";

            // Display edit and delete actions
            echo "<td>
                    <a href='" . $_SERVER['PHP_SELF'] . "?edit=" . $row['id'] . "'>Edit</a> |
                    <a href='" . $_SERVER['PHP_SELF'] . "?delete=" . $row['id'] . "'>Delete</a>
                  </td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }

    echo '<div class="logout-btn">
    <form method="GET" action="' . $_SERVER['PHP_SELF'] . '">
        <button type="submit" name="logout" class="logout-btn-style">Logout</button>
    </form>
</div>
<style>
.logout-btn-style {
    background-color: red;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
}
</style>
</body>
</html>';

    // Close the database connection
    $mysqli->close();
}

// Function to delete user
function deleteUser($userId)
{
    // Add your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registerinfo";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id = $userId";
    $result = $mysqli->query($sql);

    if ($result) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
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
    button[type="button"] {
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
    #username{
      width: 94%;
    }
    #password{
      width: 94%;
    }
  </style>
</head>
<body>
  <?php
  $error = '';
  
  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Get the submitted username and password
      $username = $_POST['username'] ?? '';
      $password = $_POST['password'] ?? '';
      
      // Perform login validation (Example: check against hardcoded values)
      $validUsername = 'admin';
      $validPassword = 'admin';
      
      if ($username === $validUsername && $password === $validPassword) {
          // Successful login
          // Set session variable to mark the admin as authenticated
          $_SESSION['admin'] = true;
          
          // Redirect to the same page to prevent form resubmission
          header('Location: ' . $_SERVER['PHP_SELF']);
          exit;
      } else {
          // Invalid credentials, display error message
          $error = 'Invalid username or password.';
      }
  }
  
  // Check if the admin is already logged in
  if (isset($_SESSION['admin'])) {
    // User is already logged in, retrieve and display user information
    if (isset($_GET['logout'])) {
        // Logout requested, destroy the session and redirect to login page
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_GET['delete'])) {
        // Delete user requested
        $userId = $_GET['delete'];
        deleteUser($userId);
        exit(); // Add this line to prevent further code execution
    } else {
        displayUserInformation();
        exit(); // Add this line to prevent further code execution
    }
  }
  ?>
  
  <div class="container">
    <h1>Admin Login</h1>
    <?php if ($error) : ?>
      <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button>
    </form>
  </div>
  
</body>
</html>
