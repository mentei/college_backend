<?php
$pdo = new PDO("mysql:host=localhost;dbname=college_db", "root", "");

// सभी users को लाओ
$query = $pdo->query("SELECT id, password FROM admin");
$users = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    // Check करो कि password पहले से hashed है या नहीं
    if (password_get_info($user['password'])['algo'] === 0) { 
        // अगर password plain है, तो इसे bcrypt में hash करो
        $hashedPassword = password_hash($user['password'], PASSWORD_BCRYPT);
        
        // Database में update करो
        $stmt = $pdo->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $user['id']]);
    }
}

echo "✅ Passwords updated successfully!";
?>
