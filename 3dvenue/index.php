<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
$file = '../common/inc/root.txt';
if (file_exists($file)) {
    $roottext = file_get_contents($file);
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = str_replace(basename(__DIR__) . '/', '', $url);
    $url = str_replace('index.php', '', $url);
    if ($roottext !== $url) {
        file_put_contents($file, $url);
    }
}
include_once('./lang.php');
?>
<!DOCTYPE html>
<html lang="<?=$lng?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css?t=<?=time()?>">
</head>
<body>
<div id="indexwrap">
    <div id="nav">

        <div id="logo">
            <a href="./" target="content">
                <img src="../common/img/logo.webp" alt="logo">
            </a>
            <h1>3Dvenue</h1>
        </div>
        <ul>
            <li id="dashbord">
                <a href="./top.php" target="content"><img src="./lib/home.svg"><?=$lang['dash'][$lng]?></a>
            </li>
        </ul>

        <h2><?=$lang['nav_header1'][$lng]?></h2>

        <ul>
            <li>
                <a href="./editor.php" target="content">
                    <img src="./lib/edit.svg"><?=$lang['page_edit'][$lng]?>
                </a>
            </li>
            <li>
                <a href="./images.php" target="content">
                    <img src="./lib/image.svg"><?=$lang['image_edit'][$lng]?>
                </a>
            </li>
            <li>
                <a href="./navi.php" target="content">
                    <img src="./lib/navigation.svg"><?=$lang['navi_edit'][$lng]?>
                </a>
            </li>
            <li>
                <a href="./color.php" target="content">
                    <img src="./lib/color.svg"><?=$lang['color_edit'][$lng]?>
                </a>
            </li>
        </ul>

        <h2><?=$lang['nav_header2'][$lng]?></h2>

        <ul>
            <li>
                <a href="./template.php" target="content">
                    <img src="./lib/template.svg"><?=$lang['template_edit'][$lng]?>
                </a>
            </li>
            <li>
                <a href="./parts.php" target="content">
                    <img src="./lib/parts.svg"><?=$lang['parts_edit'][$lng]?>
                </a>
            </li>
        </ul>

    <ul id="naviclose">
    <li>
        <span><img src="./lib/close.svg"><?=$lang['nav_close'][$lng]?></span>
    </li>
    </ul>

    </div>
    <div id="index_mein">
        <div id="header">
            <div id="menu">
                <img src="./lib/menu.svg">
            </div>
            <h2><?=$lang['dash'][$lng]?></h2>

            <div id="selectLang">
            <img src="./lib/world.svg">
            <?=selectLanguage()?>
            </div>
        </div>
        <iframe src="top.php" id="content" name="content"></iframe>
    </div><!-- index_mein -->

</div><!-- indexwrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){

        $('#menu,#naviclose').on('click',function(){
            $('#indexwrap').toggleClass('wide');            
        })

        $('#language').on('change',function(){
            const lng = $(this).val();
            $.post('lang.php',{
                language:lng
            },function(){
                location.reload();
            });
        });

    });
</script>
</body>
</html>