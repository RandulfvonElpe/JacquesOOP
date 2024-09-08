<?php
//namespace Jacques
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

switch ($method) {
    case 'GET':
        if (isset($request[0]) && is_numeric($request[0])) {
            getSupplier($request[0]);
        } else {
            getAllSupplier();
        }
        break;
    case 'POST':
        createUser();
        break;
    case 'PUT':
        if (isset($request[0]) && is_numeric($request[0])) {
            updateUser($request[0]);
        } else {
            echo json_encode(['error' => 'Invalid User ID']);
        }
        break;
    case 'DELETE':
        if (isset($request[0]) && is_numeric($request[0])) {
            deleteUser($request[0]);
        } else {
            echo json_encode(['error' => 'Invalid User ID']);
        }
        break;
    default:
        echo json_encode(['error' => 'Invalid Request Method']);
}

function getAllSupplier() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM supplier");
    $allSupplier = $stmt->fetchAll(PDO::FETCH_ASSOC);
    printAllSupplier($allSupplier);
}

function printAllSupplier($allSupplier) {
    $lenthAllSupplier = count($allSupplier);
    for ($i=0; $i<$lenthAllSupplier; $i++) {
        echo $allSupplier[$i]['supId'] . " "
             . $allSupplier[$i]['supName'] . " " 
             . $allSupplier[$i]['supEmail'] . " ";
         if ($allSupplier[$i]['supStatus'] == NULL) { echo "noch nicht geklärt". " " . $allSupplier[$i]['supInfo'];}
         if ($allSupplier[$i]['supStatus'] == 1) { echo "Kein Lieferant" . " " . $allSupplier[$i]['supInfo'];}
         if ($allSupplier[$i]['supStatus'] == 2) { echo "Lieferant" . " " . $allSupplier[$i]['supInfo'];}
         if ($allSupplier[$i]['supStatus'] == 3) { echo "Ausnahme" . " " . $allSupplier[$i]['supInfo'];}
        echo "<br>";
    } 
}

function getSupplier($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user);
}

function createUser() {
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
    if ($stmt->execute([$data['name'], $data['email'], $data['age']])) {
        echo json_encode(['success' => 'User created successfully']);
    } else {
        echo json_encode(['error' => 'Failed to create user']);
    }
}

function updateUser($id) {
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, age = ? WHERE id = ?");
    if ($stmt->execute([$data['name'], $data['email'], $data['age'], $id])) {
        echo json_encode(['success' => 'User updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update user']);
    }
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['success' => 'User deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete user']);
    }
}


