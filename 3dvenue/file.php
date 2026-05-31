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
    <link rel="stylesheet" type="text/css" href="./css/file.css?t=<?=time()?>">
</head>
<body>
<div id="main">
<div class="inner">

<section>
<div id="topmenu" class="contents">
    <div class="left">    
        <div id="toptitle">
            <h1>ファイル管理と編集</h1>
        </div>
    </div>
</div>
</section>

<section>
<h2><?=$lang['index01'][$lng]?></h2>

<div id="files" class="contents">

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
            <figure class="audio">
            <img src="./lib/mp3.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['audio_edit'][$lng]?></h3>
            <p><?=$lang['audio_memo'][$lng]?></p>
        </div>
        <a href="mp3.php"><?=$lang['open'][$lng]?> →</a>
    </div>

    <div class="content">
            <figure class="glb">
            <img src="./lib/glb.svg">
        </figure>
        <div class="text">
            <h3><?=$lang['glb_edit'][$lng]?></h3>
            <p><?=$lang['glb_memo'][$lng]?></p>
        </div>
        <a href="glb.php"><?=$lang['open'][$lng]?> →</a>
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
    // $(function(){

    //     $('#language').on('change',function(){
    //         const lng = $(this).val();
    //         $.post('lang.php',{
    //             language:lng
    //         },function(){
    //             location.reload();
    //         });
    //     });

    //     $('#pages li').on('click',function(){
    //         let pid = $(this).data('pid');
    //         $('#editor iframe').attr('src','editor.php?pid='+pid);
    //     })

    //     $('#editor .close').on('click',function(){
    //         $('#editor').removeClass();
    //     })

    //     $('#main section h2 span').on('click',function(){
    //         console.log('open');
    //       let id = $(this).data('id');
    //       $('div#'+id).toggleClass('open');
    //     })

    // });
</script>
</body>
</html>