<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $audio = $_FILES['audio'] ?? '';
    $name = $_POST['name'] ?? '';
    $submit = $_POST['submit'] ?? '';


    if($submit === '' || $name === ''){
        exit();
    }

    $mp3_dir = '../common/mp3/';
    $mp3_name = $name;

    if($submit == 'upload'){
        move_uploaded_file($audio['tmp_name'],$mp3_dir . $mp3_name);
        exit('ok');
    }

    if($submit == 'del'){
        unlink($mp3_dir . $mp3_name);
        exit('ok');
    }

}


$directory = '../common/mp3/';

if(!is_dir($directory)){
    mkdir($directory,0755,true);
}

$mp3dir = '../common/mp3/';

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
    <link rel="stylesheet" type="text/css" href="./css/mp3.css?t=<?=time()?>">
</head>
<body id="mp3page">
<div id="main">
<div class="inner">
<h2><?=$lang['audio_edit'][$lng]?><div id="new">＋</div></h2>
<p><?=$directory?></p>

<section id="audios">
    <?php
        $files = glob($directory . "*.mp3");
        foreach ($files as $file) {
        $filename = explode('.',basename($file))[0];
    ?>
    <div data-image="<?=basename($file)?>" data-name="<?=$filename?>">
        <span>♪</span>
        <span class="filename"><?=basename($file)?></span>
        <span class="btnbox"><button class="del btn"><?=$lang['del'][$lng]?></button></span>
    </div>
    <?php } ?>
        </section>
    </div>
</div><!-- main -->

<div id="mp3upload">
    <div class="close">✕</div>
        <h2>check</h2>
        <div id="soundcheck"><audio src="" id="audio" controls></audio></div>
    <div id="form">
        <label for="mp3" class="btn"><?=$lang['select'][$lng]?></label>
        <input type="file" id="mp3" accept="audio/mpeg">
        <p>
            <input type="text" name="name" id="name" value="" placeholder="<?=$lang['name'][$lng]?>">
        </p>
        <div id="btn"><button type="submit" id="submit" class="btn" name="submit" value="upload"><?=$lang['save'][$lng]?></button></div>
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function(){

let canvas;

    $('#mp3').on('change', async function(){
        const file = this.files[0];
        if(!file) return;
        $('#name').val(file.name.replace(/\.mp3$/i,''));
        $('audio#audio').attr('src',URL.createObjectURL(file));
    });

    $(document).on('click','#audios > div',function(){
        let name = $(this).data('name');
        let file = '../common/mp3/'+name+'.mp3';
        $('#mp3upload').removeClass().addClass('active check');
        $('#mp3upload h2').text('check');
        $('audio#audio').attr('src',file);
    })

    $('#submit').on('click', function(e){
        e.preventDefault();

        let file = $('#mp3')[0].files[0];
        if(!file){
            alert('MP3 is Empty!');
            return;
        }

       let name = $('#name').val();
       if(name == ''){
            alert('Name is Empty!');
            return;
        }
       let audioname = name + '.mp3';
            const fd = new FormData();
            fd.append('audio',file);
            fd.append('name',audioname);
            fd.append('submit', 'upload');
            $.ajax({
                url:'mp3.php',
                type:'POST',
                data:fd,
                processData:false,
                contentType:false,
                success:function(res){
                    if(res == 'error'){
                        alert(res);
                        return;
                    }
                     location.reload();
                }
            });
        });


    $('#new').on('click',function(){
        $('#mp3upload').removeClass().addClass('active new');
        $('#mp3upload h2').text('new');
        $('audio#audio').attr('src','');
        $('#name').val('');
    });

    $('#mp3upload .close').on('click',function(){
        $('#mp3upload').removeClass();
        $('audio#audio').attr('src','');
        $('#name').val('');
    });

    $(document).on('click','#audios .del',function(e){
        e.preventDefault();
        e.stopPropagation();
        let name = $(this).closest('div').data('name');
        let filename = name+'.mp3';
        $.post('mp3.php',{
            submit:'del',
            name:filename
        },function(res){
            if(res == 'ok'){
                location.reload();
            }
        })
    })

    // $('.view').on('click',function(){
    //     let name = $(this).closest('li').data('name');
    //     window.open('../common/pdf/'+name+'.pdf','pdf');
    // })


})
</script>

</body>
</html>