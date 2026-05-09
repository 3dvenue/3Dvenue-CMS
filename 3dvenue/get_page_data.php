<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');

$pid = $_POST['pid'] ?? null;

if ($pid) {
    $sql = "SELECT * FROM pages WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pid]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // SQLiteの改行コードや特殊文字も、json_encodeなら安全に渡せる
    echo json_encode($row);
}
exit;