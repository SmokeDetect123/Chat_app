<?php
$xmlFile = 'chat.xml';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $user = 'Steen'; // You can implement a proper user system later

    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;

    if (file_exists($xmlFile)) {
        $xml->load($xmlFile);
    } else {
        $root = $xml->createElement('chat');
        $xml->appendChild($root);
    }

    $messageElement = $xml->createElement('message');
    $userElement = $xml->createElement('user', $user);
    $textElement = $xml->createElement('text', $message);

    $messageElement->appendChild($userElement);
    $messageElement->appendChild($textElement);

    $xml->documentElement->appendChild($messageElement);
    $xml->save($xmlFile);

    echo "Message saved successfully";
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($xmlFile)) {
        header('Content-Type: application/xml');
        readfile($xmlFile);
    } else {
        echo '<?xml version="1.0"?><chat></chat>';
    }
}
?>