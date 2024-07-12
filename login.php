<?php
session_start();

// Redirect to index1.php if user is already logged in
if (isset($_SESSION["user"])) {
   header("Location: index1.php");
   exit();
}

// Process login form submission
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Include your database connection file
    require_once "database.php";

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Query to fetch user based on email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            // Verify password
            if (password_verify($password, $user["password"])) {
                // Password correct, set session and redirect
                $_SESSION["user"] = $user["email"];
                header("Location: index1.php");
                exit();
            } else {
                // Password incorrect
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        } else {
            // User not found
            echo "<div class='alert alert-danger'>Email not found</div>";
        }
    } else {
        // Query execution error
        echo "<div class='alert alert-danger'>Error executing query</div>";
    }

    // Close database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Digital Library</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <style>
        .bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%; 
            min-height: 100%;
            z-index: -1;
            opacity: 0.5;
        }
        .container {
            position: relative;
            z-index: 1;
            padding-top: 20px; /* Add padding for the navigation bar */
        }
        h1 {
            color: black;
            text-align: center;
            margin-top: 20px;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Digital Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registration.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h1>Welcome to Digital Library</h1>
    <video autoplay muted loop class="bg-video">
        <source src="video.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>