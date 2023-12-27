<?php


// Include your database connection code here
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nyabondobricks", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // Hash the new password
   // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $updateQuery = "UPDATE tbl_customer SET cust_password = :newPassword WHERE cust_email = :email";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':newPassword', $newPassword);
    $updateStmt->bindParam(':email', $email);

    try {
        $updateStmt->execute();
        echo "Password updated successfully.";
        
        // Redirect to login page after updating password
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Error updating password: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>

    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Update Password</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>
        <button type="submit">Update Password</button>
    </form>
    
</body>
</html>
