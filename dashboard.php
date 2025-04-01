<?php
session_start();
include 'db.php';

// Agar admin login nahi hai to login page pe bhej do
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Admin details fetch karna
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT username, branch FROM admins WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "Admin not found!";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background: #222;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: #bbb;
            padding: 10px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #444;
            color: #fff;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #222;
        }
        .logout {
            color: red;
            text-decoration: none;
        }
        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="notification.php">Notifications</a>
    <a href="news.php">News</a>
    <a href="faculty.php">Faculty</a>
    <a href="gallery.php">Gallery</a>
    <a href="supporting_staff.php">s.. staff</a>
</div>

<div class="content">
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($admin['username']); ?>!</h2>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <p>Hello Dear
    <?php echo htmlspecialchars($admin['username']); ?> your branch is <b><?php echo htmlspecialchars($admin['branch']); ?></b></p>
</div>

</body>
</html>
