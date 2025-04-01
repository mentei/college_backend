<?php
include 'db.php'; // Database connection file

// ✅ Handle Image Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    if (!isset($_FILES['pic'])) {
        echo "Image file is required!";
        exit;
    }

    // ✅ Image Upload Handling
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["pic"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        // ✅ Store Data in Database
        $sql = "INSERT INTO supporting_staff (name, department, position, qualification, experience, email, mobile, pic) 
                VALUES (:name, :department, :position, :qualification, :experience, :email, :mobile, :pic)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'department' => $department,
            'position' => $position,
            'qualification' => $qualification,
            'experience' => $experience,
            'email' => $email,
            'mobile' => $mobile,
            'pic' => $target_file
        ]);

        echo "<script>alert('Staff added successfully!');</script>";
    } else {
        echo "<script>alert('Image upload failed!');</script>";
    }
}

// ✅ Fetch Supporting Staff Data
$sql = "SELECT * FROM supporting_staff ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supporting Staff</title>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
    <style>
        body { font-family: Arial, sans-serif; background: #121212; color: white; padding: 20px; }
        form { max-width: 500px; margin: auto; padding: 20px; border-radius: 8px; background: #1e1e1e; }
        input, textarea, select { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; background: #333; color: white; border: 1px solid #555; }
        button { background: #007bff; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 5px; }
        button:hover { background: #0056b3; }
        .gallery { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .gallery div { text-align: center; background: #1e1e1e; padding: 10px; border-radius: 5px; }
        .gallery img { width: 150px; height: auto; border-radius: 5px; border: 2px solid white; }
    </style>
</head>
<body>

    <h2>Add Supporting Staff</h2> 
    <a href="dashboard.php"><i class="ri-dashboard-fill"></i></a>   
    <form action="supporting_staff.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="text" name="department" placeholder="Enter Department" required>
        <input type="text" name="position" placeholder="Enter Position" required>
        <input type="text" name="qualification" placeholder="Enter Qualification" required>
        <input type="text" name="experience" placeholder="Enter Experience (e.g., 5 years)">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="text" name="mobile" placeholder="Enter Mobile" required>
        <input type="file" name="pic" accept="image/*" required>
        <button type="submit">Add Staff</button>
    </form>

    <h2>Supporting Staff List</h2>
    <div class="gallery">
        <?php foreach ($staff as $person): ?>
            <div>
                <img src="<?= $person['pic'] ?>" alt="Staff Image">
                <p><?= $person['name'] ?></p>
                <p><?= $person['department'] ?></p>
                <p><?= $person['position'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
