<?php
include 'db.php'; // Database Connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $branch = $_POST['branch'];

    if (empty($first_name) || empty($last_name) || empty($username) || empty($_POST['password']) || empty($branch)) {
        $error = "All fields are required!";
    } else {
        $sql = "INSERT INTO admins (first_name, last_name, username, password, branch) 
                VALUES (:first_name, :last_name, :username, :password, :branch)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'password' => $password,
            'branch' => $branch
        ])) {
            echo "<script>
                    alert('Registration Successful!');
                    window.location.href = 'dashboard.php';
                </script>";
        } else {
            $error = "Registration Failed! Try Again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 400px; margin-top: 50px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Admin Register</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <select name="branch" class="form-control" required>
                    <option value="">Select Branch</option>
                    <option value="CSE">CSE</option>
                    <option value="CIVIL">CIVIL</option>
                    <option value="ECE">ECE</option>
                    <option value="MECH">MECH</option>
                    <option value="HUMINI">HUMANITIES</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</body>
</html>
