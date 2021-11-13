<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once('settings.php');

$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);


$stmt = $pdo->prepare('SELECT led_id, switch_on FROM leds');
$stmt->execute();

$ons = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($ons as &$on)
{
    foreach ($on as &$val)
    {
        $val = (int)$val;
    }
}

echo json_encode($ons);
