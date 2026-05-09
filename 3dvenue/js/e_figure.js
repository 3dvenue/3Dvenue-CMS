/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$('#aspectbox .aspect').on('click', function(){
    let aspect = $(this).data('aspect');
    console.log(aspect);
	$('figure.active').parent().siblings().addBack().find('figure').css('aspect-ratio', aspect); 
});

$('#selectimage').on('click',function(){
    $('#images').addClass('figure');
})


$(document).on('click','#images.figure ul li',function(){
    let imgurl = $(this).attr('data-url');
    $('main section figure.active img').attr({'src':imgurl});
    $('#images').removeClass('figure');
})

$('#altsetup').on('click',function(){
    let alt = $('#alt').val();
    $('figure.active').find('img').attr('alt',alt);
})

$('#imagelinkset').on('click',function(){
    setImageLink();
})


function setImageLink() {
    const url = $('#imagelink').val();
    const target = $('#imagelink_target').val(); // 必要なら

    const $figure = $('figure.active');
    const $a = $figure.find('a');
    const $img = $figure.find('img');

    if ($a.length) {
        // 既存リンク → 属性を書き換えるだけ
        $a.attr('href', url);
        if (target) $a.attr('target', target);
    } else {
        // リンクがない → wrap する
        let tag = `<a href="${url}"`;
        if (target) tag += ` target="${target}"`;
        tag += ` class="active"></a>`;
        $img.wrap(tag);
    }
}

function unsetImageLink() {
    $('figure.active a').replaceWith(function() {
        return $(this).contents();
    });
}


    $(document).on('click','#images.active ul li',function(){
        let imgurl = $(this).attr('data-url');
        $('main section.active,#bgPreview').css({'background-image':'url('+imgurl+')'});
        $('#images').removeClass('active');
    })

    $('#imageselect').on('click',function(){
        $('#images').addClass('active');
    })

    $('.closeimage').on('click',function(){
        $('#images').removeClass();
    })

    $('#bgDelete').on('click',function(){
        $('main section.active,#bgPreview').css({'background-image':''});      
    })
