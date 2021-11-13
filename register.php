<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once('settings.php');

if (!isset($_GET['email']))
{
    exit(0);
}

$email = $_GET['email'];

$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

$stmt = $pdo->prepare('SELECT count(*) FROM users WHERE email = ?');
$stmt->execute([$email]);

$count = (int)($stmt->fetchColumn());
// echo $count; 
if ($count > 0) // existing email addr
{
    // do nothing
}
else
{
    $stmt = $pdo->prepare('INSERT INTO users (email) VALUES (?)');
    $stmt->execute([$email]);
}

$stmt = $pdo->prepare('SELECT `id` FROM users WHERE email = ?');
$stmt->execute([$email]);

$id = (int)($stmt->fetchColumn());

echo json_encode(['id' => $id]);
