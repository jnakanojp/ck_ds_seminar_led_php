<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once('settings.php');

$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

if (!isset($_REQUEST['led_id']))
{
    exit(0);
}

$led_id = (int)$_REQUEST['led_id'];


$stmt = $pdo->prepare('SELECT count(*) FROM leds WHERE led_id = ?');
$stmt->execute([$led_id]);

$count = (int)($stmt->fetchColumn());
// echo $count; 
if ($count > 0) // existing email addr
{
    // do nothing
}
else
{
    $stmt = $pdo->prepare('INSERT INTO leds (led_id, switch_on) VALUES (?, 0)');
    $stmt->execute([$led_id]);
}

if (isset($_REQUEST['switch_on']))
{
    $on = (int)$_REQUEST['switch_on'];
    $stmt = $pdo->prepare('UPDATE leds SET switch_on = ? WHERE led_id = ?');
    $stmt->execute([$on, $led_id]);
}

$stmt = $pdo->prepare('SELECT switch_on FROM leds WHERE led_id = ?');
$stmt->execute([$led_id]);

$on = $stmt->fetchColumn();

echo json_encode(['led_id' => $led_id, 'switch_on' => $on == 0 ? false : true]);
