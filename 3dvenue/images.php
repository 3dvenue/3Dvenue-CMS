<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $name = $_POST['name'] ?? '';
    if ($type == "delete" && !empty($name)) {
        if (file_exists($name)) {
            unlink($name);
        }
     }
     exit();
}

$directory = '../common/img/';

include_once('./lang.php');
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/images.css?t=<?=time()?>">
</head>
<body id="imagepage">
<div id="main">
<div class="inner">
    <h2><?=$lang['image_edit'][$lng]?><div id="new">＋</div></h2>
    <p><?=$directory?></p>
     <section id="images">
        <?php
            $files = glob($directory . "*.webp");
        ?>
    <ul>
    <?php
        foreach ($files as $file) {
        $filename = explode('.',basename($file))[0];
    ?>
    <li data-image="<?=basename($file)?>" data-name="<?=$filename?>">
        <figure>
            <img src="<?=$directory.basename($file)?>?t=<?=time()?>">
            <figcaption><?=basename($file)?></figcaption>
        </figure>
    </li>
    <?php } ?>
    </ul>
    </section>
    </div>
</div><!-- main -->
<?php include_once('./inc/imageupload.php')?>
<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
<?php include_once "./js/imageupload.js"; ?>
});    
</script>
</body>
</html>