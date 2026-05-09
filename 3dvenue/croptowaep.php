<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cropname  = $_POST['cropname'];
    $cropdata  = $_POST['cropdata'] ?? '';
    $saveImage = function($cropname, $base64Data) {
        if (!$base64Data) return;  
        $img = str_replace('data:image/png;base64,', '', $base64Data);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        $targetPath = "../common/img/{$cropname}.webp"; 
        file_put_contents($targetPath, $fileData);
    };

	$saveImage($cropname, $cropdata);

header('Location: images.php');
exit;
}
?>

