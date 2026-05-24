<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
$root = file_get_contents('../common/inc/root.txt');
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
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/top.css?t=<?=time()?>">
</head>
<body>
<div id="main">
<div class="inner">

<section>
<div id="topmenu" class="contents">
    <div class="left">    
        <div id="toptitle">
            <h1><?=$lang['nav_header1'][$lng]?></h1>
            <div class="welcome">Welcome to 3Dvenue-CMS</div>
        </div>
        <div class="card">
            <div id="score100">100</div>
            <div>
                <p class="memo">
                <strong>Google PageSpeed Insights</strong>
                <?=$lang['indextop'][$lng]?>
                </p>
                <a href="https://pagespeed.web.dev/" target="insights" class="btn" id="toInsights">PageSpeed Insightsへ</a>
            </div>
        </div>
    </div>
    <div class="card right">
        <h2>Site Information</h2>
        <table>
            <tr><th>CMS Root<th><td><a href="<?=$root?>" target="_blank"><?=$root?></a><td></tr>
            <tr><th>CMS Version<th><td>0.9.8-beta<td></tr>
            <tr><th>PHP Version<th><td><?=phpversion()?><td></tr>
            
        </table>
    </div>
</div>
</section>

<section>
<h2><?=$lang['index01'][$lng]?></h2>

<div id="analog" class="contents">

    <div class="content">
            <figure class="page">
            <img src="./lib/edit.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['page_edit'][$lng]?></h3>
            <p><?=$lang['page_edit_memo'][$lng]?></p>
        </div>
        <a href="editor.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
            <figure class="image">
            <img src="./lib/image.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['image_edit'][$lng]?></h3>
            <p><?=$lang['image_edit_memo'][$lng]?></p>
        </div>
        <a href="images.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
            <figure class="pdf">
            <img src="./lib/pdf.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['pdf_edit'][$lng]?></h3>
            <p><?=$lang['navi_edit_memo'][$lng]?></p>
        </div>
        <a href="pdf.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
            <figure class="navi">
            <img src="./lib/navigation.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['navi_edit'][$lng]?></h3>
            <p><?=$lang['navi_edit_memo'][$lng]?></p>
        </div>
        <a href="navi.php"><?=$lang['open'][$lng]?> →</a>
    </div>

</div>
</section>

<section>

<h2><?=$lang['index02'][$lng]?></h2>

<div id="technical" class="contents">
    <div class="content">
        <div class="flex">
            <figure class="template">
                <img src="./lib/template.svg">
            </figure>
            <h3><?=$lang['template_edit'][$lng]?></h3>
        </div>
        <div class="text">
            <p><?=$lang['template_edit_memo'][$lng]?></p>
        </div>
        <a href="template.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
        <div class="flex">
            <figure class="parts">
                <img src="./lib/parts.svg">
            </figure>
            <h3><?=$lang['parts_edit'][$lng]?></h3>
        </div>
        <div class="text">
            <p><?=$lang['parts_edit_memo'][$lng]?></p>
        </div>
        <a href="parts.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
        <div class="flex">
            <figure class="color">
                <img src="./lib/color.svg">
            </figure>
         <h3><?=$lang['color_edit'][$lng]?></h3>
        </div>
        <div class="text">
            <p><?=$lang['color_edit_memo'][$lng]?></p>
        </div>
        <a href="color.php"><?=$lang['open'][$lng]?> →</a>
    </div>


</div>
</section>

</div>
</div><!-- main -->
<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){

        $('#language').on('change',function(){
            const lng = $(this).val();
            $.post('lang.php',{
                language:lng
            },function(){
                location.reload();
            });
        });

        $('#pages li').on('click',function(){
            let pid = $(this).data('pid');
            $('#editor iframe').attr('src','editor.php?pid='+pid);
        })

        $('#editor .close').on('click',function(){
            $('#editor').removeClass();
        })

        $('#main section h2 span').on('click',function(){
            console.log('open');
          let id = $(this).data('id');
          $('div#'+id).toggleClass('open');
        })

    });
</script>
</body>
</html>