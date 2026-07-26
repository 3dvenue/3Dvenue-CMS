<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit = $_POST['submit'] ?? '';
    $cid    = $_POST['cid'] ?? '';
    $type   = $_POST['type'] ?? '0';
    $cname  = $_POST['cname'];
    $dom    = $_POST['dom'];
    $memo   = $_POST['memo'];
    $cimage = $_POST['cimage'] ?? ''; // JSから届くBase64データ

    $saveImage = function($id, $base64Data) {
        if (!$base64Data) return;
        $img = preg_replace('/^data:image\/png;base64,/', '', $base64Data);
        $img = str_replace(' ', '+', $img);
        $binary = base64_decode($img);
        $pngPath = "./parts/{$id}.png";
        file_put_contents($pngPath, $binary);
        $image = imagecreatefrompng($pngPath);
        $webpPath = "./parts/{$id}.webp";
        imagewebp($image, $webpPath, 80);
        imagedestroy($image);
        unlink($pngPath);
    };

    if ($submit === 'add') {
        $sql = "INSERT INTO contents (type, cname, dom, memo) VALUES (:type, :cname, :dom, :memo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':type'  => $type,
            ':cname' => $cname,
            ':dom'   => $dom,
            ':memo'  => $memo
        ]);
        
        // 【重要】新規作成されたIDを取得して画像を保存
        $newId = $conn->lastInsertId();
        $saveImage($newId, $cimage);
    }

    if ($submit === 'edit') {
        $sql = "UPDATE contents SET cname = :cname, type = :type, dom = :dom, memo = :memo WHERE cid = :cid";            
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':type'  => $type,
            ':cname' => $cname,
            ':dom'   => $dom,
            ':memo'  => $memo,
            ':cid'   => $cid
        ]);
        
        // 既存のIDで画像を上書き保存
        $saveImage($cid, $cimage);
    }

    if ($submit === 'del') {
        $sql = "DELETE FROM contents WHERE cid = :cid";            
        $stmt = $conn->prepare($sql);
        $stmt->execute([':cid' => $cid]);
        
        // 削除時は画像も消しておくとストレージが汚れない
        $targetPath = "./parts/{$cid}.webp";
        if (file_exists($targetPath)) unlink($targetPath);
    }

    header('Location: parts.php?t='.$type); 
    exit;
}
?>