<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf = $_FILES['pdf'] ?? '';
    $image = $_FILES['image'] ?? '';
    $name = $_POST['name'] ?? '';
    $submit = $_POST['submit'] ?? '';


    if($submit === '' || $name === ''){
        exit();
    }

    $pdf_dir = '../common/pdf/';
    $pdf_name = $name . '.pdf';
    $img_name = $name . '.webp';

    if($submit == 'upload'){
        move_uploaded_file($pdf['tmp_name'],$pdf_dir . $pdf_name);
        move_uploaded_file($image['tmp_name'],$pdf_dir . $img_name);
        exit('ok');
    }

    if($submit == 'del'){
        unlink($pdf_dir . $pdf_name);
        unlink($pdf_dir . $img_name);
        exit('ok');
    }

}


$directory = '../common/pdf/';
if(!is_dir($directory)){
    mkdir($directory,0755,true);
}

$pdfdir = '../common/pdf/';

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
    <link rel="stylesheet" type="text/css" href="./css/pdf.css?t=<?=time()?>">
</head>
<body id="pafpage">
<div id="main">
    <div class="inner">
        <h2><?=$lang['pdf_edit'][$lng]?><div id="new">＋</div></h2>
        <p><?=$directory?></p>
         <section id="pdfs">
            <?php
                $files = glob($directory . "*.pdf");
            ?>
        <ul>
        <?php
            foreach ($files as $file) {
            $filename = explode('.',basename($file))[0];
        ?>
        <li data-image="<?=basename($file)?>" data-name="<?=$filename?>">
            <figure>
                <img src="<?=$pdfdir.$filename?>.webp?t=<?=time()?>">
                <figcaption><?=basename($file)?></figcaption>
            </figure>
            <div class="btnbox"><button class="view btn"><?=$lang['check'][$lng]?></button><button class="del btn"><?=$lang['del'][$lng]?></button></div>
        </li>
        <?php } ?>
        </ul>
        </section>
    </div>
</div><!-- main -->


<div id="pdfupload">
    <div class="close">✕</div>
        <h2>preview</h2>
        <div id="view"></div>
    <div id="form">
        <label for="pdf" class="btn"><?=$lang['select'][$lng]?></label>
        <input type="file" id="pdf" accept="application/pdf">
        <p>
            <input type="text" name="imgname" id="imgname" value="<?=$lang['name'][$lng]?>">
        </p>
        <div id="btn"><button type="submit" id="submit" class="btn" name="submit" value="upload"><?=$lang['save'][$lng]?></button></div>
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

$(function(){

let canvas;

    $('#pdf').on('change', async function(){
        const file = this.files[0];
        if(!file) return;

        $('#imgname').val(file.name.replace(/\.pdf$/i,''));

        const data = await file.arrayBuffer();
        const pdf  = await pdfjsLib.getDocument({data:data}).promise;
        const page = await pdf.getPage(1);

        const scale = 1.0;
        const vp = page.getViewport({scale:scale});

        canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = vp.width;
        canvas.height = vp.height;

        await page.render({
            canvasContext:ctx,
            viewport:vp
        }).promise;

        canvas.toBlob(function(blob){
            const url = URL.createObjectURL(blob);
            $('#view').css('background-image', 'url(' + url + ')');
        }, 'image/webp', 0.8);
    });



    $('#submit').on('click', function(e){
        e.preventDefault();
       if(!canvas) return;
       let name = $('#imgname').val();
       if(name == ''){
        alert('Name is Empty!');
        return;
        }

       let webp = name + '.webp';
        canvas.toBlob(function(blob){
            const fd = new FormData();
            fd.append('pdf', $('#pdf')[0].files[0]);
            fd.append('image', blob, webp);
            fd.append('name',name);
            fd.append('submit', 'upload');
            $.ajax({
                url:'pdf.php',
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
                    console.log(res);
                }
            });
        }, 'image/webp', 0.8);
    });


    $('#new').on('click',function(){
        $('#pdfupload').removeClass().addClass('active new');
        // $('#imgname').val('');
        // $('#view').css('background-image', '');
    });

    $('#pdfupload .close').on('click',function(){
        $('#pdfupload').removeClass();
        // $('#imgname').val('');
        // $('#view').css('background-image', '');
    });


    $(document).on('click','.del',function(){
        let name = $(this).closest('li').data('name');
        $.post('pdf.php',{
            submit:'del',
            name:name
        },function(res){
            if(res == 'ok'){
                location.reload();
            }
        })
    })

    $('.view').on('click',function(){
        let name = $(this).closest('li').data('name');
        window.open('../common/pdf/'+name+'.pdf','pdf');
    })


})
</script>

</body>
</html>