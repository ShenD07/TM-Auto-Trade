<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  if (isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      $_SESSION['user_id'] = $userId;
      $_SESSION['full_name'] = $user['full_name'];
    } else {
      header("Location: index.php");
      exit;
    }
  } else {
    header("Location: index.php");
    exit;
  }
}

$name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - TM Auto Trade</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      padding: 2rem;
      text-align: center;
    }

    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #4191CE;
      display: flex;
      justify-content: space-around;
      align-items: center;
      height: 70px;
      box-shadow: 0 -2px 5px rgba(0,0,0,0.05);
      padding: 0 10px;
    }

    .bottom-nav a {
      text-decoration: none;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .bottom-nav img {
      width: 30px;
      height: 30px;
      opacity: 0.6;
      transition: opacity 0.3s;
    }

    .bottom-nav a.active img {
      opacity: 1;
    }

    .bottom-nav a:hover img {
      opacity: 0.9;
    }

    .bottom-nav .add-button {
      background-color: white;
      width: 65px;
      height: 65px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      top: -18px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .bottom-nav .add-button img {
      width: 60px;
      height: 60px;
    }
  </style>
</head>
<body>

  <main>
    <h2>TM Auto Trade Dashboard</h2>
    <p>Manage vehicles and details from this panel.</p>
  </main>

  <div class="bottom-nav">
    <a href="dashboard.php" class="active"><img src="Images/home.png" alt="Home" /></a>
    <a href="vehicles.php"><img src="Images/car.png" alt="Vehicles" /></a>
    <a href="vehicle_form.html" class="add-button">
      <img src="Images/plus_btn.png" alt="Add" />
    </a>
    <a href="earns.php"><img src="Images/earns.png" alt="Earns" /></a>
    <a href="profile.php"><img src="Images/user.png" alt="Profile" /></a>
  </div>

</body>
</html>
