<?php
include 'db.php'; // Database connection file

// ✅ Handle Image Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    if (!isset($_FILES['image'])) {
        echo "<script>alert('Image file is required!');</script>";
        exit;
    }

    // ✅ Image Upload Handling
    $target_dir = "uploads/gallery/"; // Folder must exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // ✅ Store Data in Database
        $sql = "INSERT INTO gallery (title, category, description, image_url) VALUES (:title, :category, :description, :image_url)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'image_url' => $target_file
        ]);

        echo "<script>alert('Image uploaded successfully!');</script>";
    } else {
        echo "<script>alert('Image upload failed!');</script>";
    }
}

// ✅ Fetch Gallery Images
$sql = "SELECT * FROM gallery ORDER BY uploaded_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Admin Panel</title>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <style>
        /* ✅ Dark Theme & Responsive */
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #333;
            background: #1e1e1e;
            border-radius: 8px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        button {
            background: #ff9800;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background: #e68900;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .gallery div {
            text-align: center;
            background: #222;
            padding: 10px;
            border-radius: 5px;
        }
        .gallery img {
            width: 200px;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
        @media (max-width: 600px) {
            .gallery img { width: 150px; }
        }
    </style>
</head>
<body>

    <h2>Upload Image to Gallery</h2> <a href="dashboard.php"><i class="ri-dashboard-fill"></i></a>   
    <form action="gallery.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Enter title" required>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Event">Event</option>
            <option value="Workshop">Workshop</option>
            <option value="Competition">Competition</option>
        </select>
        <textarea name="description" placeholder="Enter description"></textarea>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Gallery Images</h2>
    <div class="gallery">
        <?php foreach ($images as $image): ?>
            <div>
                <img src="<?= $image['image_url'] ?>" alt="Gallery Image">
                <p><?= $image['title'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
