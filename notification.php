<?php
session_start();
ini_set('session.gc_maxlifetime', 3600); // 1 hour session
session_set_cookie_params(3600);

include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    echo "Session Data: ";
    print_r($_SESSION); // Debugging
    header("Location: login.php");
    exit();
}

// Notification Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $attachments = $_POST['attachments'];
        
        $sql = "INSERT INTO notifications (title, content, attachments) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $attachments]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

$notifications = $pdo->query("SELECT * FROM notifications")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>

</head>
<body class="container mt-4">
    <h2>Admin Panel - Notifications</h2>
    <a href="dashboard.php"><i class="ri-dashboard-fill"></i></a>   
    
    <form method="POST" enctype="multipart/form-data" class="mb-3">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
        <textarea name="content" placeholder="Content" class="form-control mb-2" required></textarea>
        <input type="file" name="attachments" class="form-control mb-2">
        <button type="submit" name="add" class="btn btn-primary">Add Notification</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Attachments</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notifications as $note): ?>
                <tr>
                    <td><?= $note['id'] ?></td>
                    <td><?= htmlspecialchars($note['title']) ?></td>
                    <td><?= htmlspecialchars($note['content']) ?></td>
                    <td>
                        <?php if (!empty($note['attachments'])): ?>
                            <a href="<?= htmlspecialchars($note['attachments']) ?>" target="_blank">View File</a>
                        <?php else: ?>
                            No Attachment
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $note['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
