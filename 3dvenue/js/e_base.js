/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

// 設定ボタンクリック
$('#setting').on('click',function(){
    $('body').toggleClass('base');
})

$('.baseMenu .close').on('click',function(){
    $('.baseMenu .close').removeClass('active');
})


$('#snsimage').on('change',function(){
    drawCanvas();
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        $('#snsview').css('background-image', 'url(' + e.target.result + ')');
    };
    reader.readAsDataURL(file);  
})

$('#seoeditor .btn').on('click',function(){
      let pagetitle = $('#pagetitle').val();
      let description = $('#description').val();
      let other = $('#other').val();
      let snsimage = $('#snsimage').val();
      let jsonld = $('#jsonld').val();
      let noidex = $('#noidex').prop('checked') ? 1 : 0;
      let name = $(this).data('name');
    if(name !== 'sitename' && name !== 'snsimage'){
        $.post('sqlupdate.php', {
            pid: '<?=$pid?>',
            table: 'pages',
            pagetitle:pagetitle,
            description:description,
            other:other,
            jsonld:jsonld,
            noidex:noidex,
            submit:'seo'
        }, function(res){
            $('details').removeAttr('open');
            alert('SEO情報が更新されました');
            $('#seoeditor').removeClass('active');
         });
    }else if(name == 'sitename'){ //サイト名は共通のSEO
     let sitename = $('#sitename').val();
        $.post('sqlupdate.php', {
            sitename:sitename,
            submit:name
        }, function(res){
            $('details').removeAttr('open');
            alert('サイト名が更新されました');
            $('#seoeditor').removeClass('active');
         });
    }else if(name == 'snsimage'){
        snsImageSend();
    }
});

function drawCanvas() {
    const file = $('#snsimage').prop('files')[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            // 大事な「規格統一」の作業
            const targetW = 1200;
            const targetH = 600;
            canvas.width = targetW;
            canvas.height = targetH;

            const ratio = Math.max(targetW / img.width, targetH / img.height);
            const x = (targetW - img.width * ratio) / 2;
            const y = (targetH - img.height * ratio) / 2;

            ctx.drawImage(img, x, y, img.width * ratio, img.height * ratio);
            hasImage = true;
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}


function snsImageSend() {
    if (!hasImage) return alert('画像を選択してください');

    canvas.toBlob(function(blob) {
        // 変数名も、見せていただいた実績通りの「formData」
        const formData = new FormData();

        // 命名規則も村井さんの決定通り。送り先も実績のある場所へ。
        formData.append('file', blob, 'snsimage' + '<?=$pid?>' + '.webp');

        $.ajax({
            url: './lib/upload.php', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                // 物理ファイルが更新されたので、リロードして「ポン」と終わる
                location.reload();
            }
        });
    }, 'image/webp', 0.8);
}

