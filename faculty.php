<?php
include 'db.php'; // Database connection

// ✅ Handle Faculty Image Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    if (!isset($_FILES['pic'])) {
        echo "Faculty image is required!";
        exit;
    }

    // ✅ Image Upload
    $target_dir = "uploads/faculty/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["pic"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        // ✅ Store in Database
        $sql = "INSERT INTO faculties (name, department, position, qualification, experience, email, mobile, pic) 
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

        echo "<script>alert('Faculty uploaded successfully!');</script>";
    } else {
        echo "<script>alert('Upload failed!');</script>";
    }
}

// ✅ Fetch Faculty Data
$sql = "SELECT * FROM faculties ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Panel</title>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { padding: 20px; background: #121212; color: #fff; }

        /* ✅ Form Styling */
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background: #222;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
        }

        h2 { text-align: center; margin-bottom: 15px; }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background: #333;
            color: white;
            border: 1px solid #444;
            border-radius: 5px;
        }

        button {
            width: 100%;
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover { background: #218838; }

        /* ✅ Faculty Gallery */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .gallery img {
            width: 100%;
            max-height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #444;
        }

        .faculty-card {
            background: #222;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.1);
        }

        /* ✅ Responsive Design */
        @media (max-width: 600px) {
            .form-container { width: 90%; }
            .gallery { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
        }
    </style>
</head>
<body>
<a href="dashboard.php"><i class="ri-dashboard-fill"></i></a>   

    <h2>Upload Faculty Image</h2>
    <div class="form-container">
        <form action="faculty.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="department" placeholder="Department" required>
            <input type="text" name="position" placeholder="Position" required>
            <input type="text" name="qualification" placeholder="Qualification" required>
            <input type="text" name="experience" placeholder="Experience" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="mobile" placeholder="Mobile No" required>
            <input type="file" name="pic" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>

    <h2>Faculty Gallery</h2>
    <div class="gallery">
        <?php foreach ($faculties as $faculty): ?>
            <div class="faculty-card">
                <img src="<?= $faculty['pic'] ?>" alt="Faculty Image">
                <p><strong><?= $faculty['name'] ?></strong></p>
                <p><?= $faculty['department'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
