/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

    let canvas = document.createElement('canvas');
    let ctx = canvas.getContext('2d');
    let hasImage = false;

    $('#file').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const validTypes = ['image/png', 'image/jpeg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            $(this).val(''); 
            return;
        }

        if(!$('#imageupload').hasClass('edit')){
        const fileNameWithoutExt = file.name.replace(/\.[^/.]+$/, "");
        $('#imgname').val(fileNameWithoutExt);
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            // プレビュー表示
            $('#view').css('background-image', 'url(' + e.target.result + ')');

            const img = new Image();
            img.onload = function() {
                let width = img.width;
                let height = img.height;
                const MAX_SIZE = 1280;

                if (width > MAX_SIZE || height > MAX_SIZE) {
                    if (width > height) {
                        height *= MAX_SIZE / width;
                        width = MAX_SIZE;
                    } else {
                        width *= MAX_SIZE / height;
                        height = MAX_SIZE;
                    }
                }

                // Canvasを画像ピッタリのサイズに設定（余白なし）
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);
                hasImage = true;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    // アップロード実行（#submitボタン）
    $('#submit').on('click', function() {
        if (!hasImage) {
            alert("画像を選択してください");
            return;
        }

        // #imgname から現在の値を取得（手入力で変更されていても反映）
        const finalFileName = $('#imgname').val();
        if (!finalFileName) {
            alert("画像名を入力してください");
            return;
        }

        // Canvasから高品質なWebPを作成して送信
        canvas.toBlob(function(blob) {
            const formData = new FormData();
            
            // サーバーへ送るファイル名を「#imgnameの値.webp」に指定
            formData.append('file', blob, `${finalFileName}.webp`);

            $.ajax({
                url: './lib/upload.php', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    location.reload();
                },
                error: function() {
                    alert("保存に失敗しました");
                }
            });
        }, 'image/webp', 0.85); // 85%の画質設定
    });

    $('#new').on('click',function(){
        $('#imageupload').removeClass().addClass('active new');
        $('#imgname').val('');
        $('#view').css('background-image', '');
    });

let imageName = "";

    $('body#imagepage #images ul li').on('click',function(){
        let image = $(this).data('image');
        let name = $(this).data('name');
        let imageurl = '../common/img/'+ image;
        $('#cropview img').remove();
        $('#cropview').append('<img src="'+imageurl+'">');
        $('#cropname').val(name+'-1x1');
        imageName = name;
        $('#imagecrop').removeClass().addClass('active edit');
        $('#delete').attr('data-image',imageurl);
    });

    $('#imageupload .close,#imagecrop .close').on('click',function(){
        $('#imageupload,#imagecrop').removeClass('active');
    });


    $('#delete').on('click', function(){
        let image = $(this).attr('data-image');
        $.post('images.php', {
            type: 'delete',
            name: image
        }).done(function(data) {
            location.reload();
        })
    });


    $('#cropper').draggable({
        containment: 'parent',
    }).resizable({
        containment: 'parent',
        aspectRatio: true,
        handles: 'all',
    });


    $('.aspect').on('click',function(){
        let ratio = $(this).attr('data-aspect');
        let width = parseFloat($('#cropper').css('width'));
        $('.aspect').removeClass('active');
        $(this).addClass('active');
        let aspect = ratio.split('/');
        let height = (width / aspect[0] * aspect[1]).toFixed(3);
        $('#cropper').css({'height':height+'px'});
        $('#cropper').css({'aspect-ratio':aspect});
        $('#cropname').val(imageName+'-'+aspect[0]+'x'+aspect[1]);
    })

    $('input#croprange').on('input',function(){
        let range = $(this).val();
        console.log(range);
        $('#cropview img').css({'transform':'rotate('+range+'deg)'});
    })

    $('#makeCrop').on('click', function(){
        let img = $('#cropview img')[0];
        let cw = $('#cropper').width();
        let ch = $('#cropper').height();
        let po = $('#cropview img').offset();
        let co = $('#cropper').offset();
        let left = po.left - co.left;
        let top  = po.top  - co.top;
        let iw = $('#cropview img').width();
        let ih = $('#cropview img').height();
        let name = $('#cropname').val();
        let canvas = document.createElement('canvas');
        canvas.width = cw;
        canvas.height = ch;
        let ctx = canvas.getContext('2d');
        ctx.drawImage(
            img,
            left,
            top,
            iw,
            ih
        );
        canvas.toBlob(function(blob){
            const formData = new FormData();
            formData.append('file', blob, name + '.webp');

            $.ajax({
                url: './lib/upload.php', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    location.reload();
                }
            });
        }, 'image/webp', 0.9);
    });