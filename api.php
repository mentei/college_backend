<?php
header("Content-Type: application/json");
include 'db.php';

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
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

function handleGet($pdo) {
    $sql = "SELECT * FROM admins";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

function handlePost($pdo, $input) {
    if (!isset($input['username']) || !isset($input['password']) || !isset($input['branch'])) {
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $sql = "INSERT INTO admins (username, password, branch) VALUES (:username, :password, :branch)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $input['username'],
        'password' => password_hash($input['password'], PASSWORD_DEFAULT), // Secure password storage
        'branch' => $input['branch']
    ]);

    echo json_encode(['message' => 'User created successfully']);
}

function handlePut($pdo, $input) {
    if (!isset($input['id']) || !isset($input['username']) || !isset($input['password']) || !isset($input['branch'])) {
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $sql = "UPDATE admins SET username = :username, password = :password, branch = :branch WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $input['username'],
        'password' => password_hash($input['password'], PASSWORD_DEFAULT),
        'branch' => $input['branch'],
        'id' => $input['id']
    ]);

    echo json_encode(['message' => 'User updated successfully']);
}

function handleDelete($pdo, $input) {
    if (!isset($input['id'])) {
        echo json_encode(['error' => 'Missing ID']);
        return;
    }

    $sql = "DELETE FROM admins WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $input['id']]);
    echo json_encode(['message' => 'User deleted successfully']);
}
?>
