<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Image Upload Logic
        $targetDir = "uploads/news/"; // Folder where images will be stored
        $imageName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;
        $imageType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Store image path in database
                $sql = "INSERT INTO news (title, content, image) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $content, $targetFilePath]);
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        // Delete image from folder
        $stmt = $pdo->prepare("SELECT image FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && file_exists($row['image'])) {
            unlink($row['image']); // Delete file
        }

        // Delete from database
        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

// Fetch all news
$newsList = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
</head>
<body class="container mt-4 background-black">

    <h2>Admin Panel - News</h2>
 <a href="dashboard.php"><i class="ri-dashboard-fill"></i></a>   
    <form method="POST" enctype="multipart/form-data" class="mb-3">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
        <textarea name="content" placeholder="Content" class="form-control mb-2" required></textarea>
        <input type="file" name="image" class="form-control mb-2" required>
        <button type="submit" name="add" class="btn btn-primary">Add News</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newsList as $news): ?>
                <tr>
                    <td><?= $news['id'] ?></td>
                    <td><?= htmlspecialchars($news['title']) ?></td>
                    <td><?= htmlspecialchars($news['content']) ?></td>
                    <td>
                        <?php if (!empty($news['image'])): ?>
                            <img src="<?= htmlspecialchars($news['image']) ?>" alt="News Image" width="80">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $news['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
