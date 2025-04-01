<?php
header("Content-Type: application/json");
include 'db.php';

// Database connection check
if (!$pdo) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Get request method and input data
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        handleGet($pdo);
        break;
    case 'POST':
        handlePost($pdo, $input);
        break;
    case 'PUT':
        handlePut($pdo, $input);
        break;
    case 'DELETE':
        handleDelete($pdo, $input);
        break;
    default:
        echo json_encode(['error' => 'Invalid request method']);
        break;
}

function handleGet($pdo) {
    try {
        $sql = "SELECT id, username, branch FROM admin";  // Only fetching required columns
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error fetching users: ' . $e->getMessage()]);
    }
}

function handlePost($pdo, $input) {
    if (!isset($input['username']) || !isset($input['password']) || !isset($input['branch'])) {
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    try {
        $sql = "INSERT INTO admin (username, password, branch) VALUES (:username, :password, :branch)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $input['username'],
            'password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'branch' => $input['branch']
        ]);
        echo json_encode(['message' => 'User created successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error inserting user: ' . $e->getMessage()]);
    }
}

function handlePut($pdo, $input) {
    if (!isset($input['id']) || !isset($input['username']) || !isset($input['password']) || !isset($input['branch'])) {
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    try {
        $sql = "UPDATE admin SET username = :username, password = :password, branch = :branch WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $input['username'],
            'password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'branch' => $input['branch'],
            'id' => $input['id']
        ]);
        echo json_encode(['message' => 'User updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
    }
}

function handleDelete($pdo, $input) {
    if (!isset($input['id'])) {
        echo json_encode(['error' => 'Missing ID']);
        return;
    }

    try {
        $sql = "DELETE FROM admin WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $input['id']]);
        echo json_encode(['message' => 'User deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error deleting user: ' . $e->getMessage()]);
    }
}
?>
