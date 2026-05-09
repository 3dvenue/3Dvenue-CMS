/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$('section div.parts').on('click', function(){
    const cid = $(this).data('cid');
    let place = $('#addsection .addsection:checked').val();
    const data = allParts.find(p => p.cid == cid);
    $section = $('main section.active');
        if(place == "before"){
            $section.before(data.dom);
        }
        if(place == "after"){
            $section.after(data.dom);
        }        
    $('#parts').removeClass('active');
});

$('#parts .sectionClose').on('click',function(){
    $('#parts').removeClass('active');
})

$('#section .section button').on('click',function(){
    let id = $(this).attr('id');
    if(id == "delSection"){
        $('main section.active').remove();
    }

    if(id == "addSection"){
        $('#parts').addClass('active addsection');
    }

})

$('#newpage').on('click',function(){
    $('#parts').removeClass().addClass('active pageparts');  
})

$('#parts #addPage section .pages').on('click',function(){
    let cid = $(this).data('cid');
    $('#tempid').val(cid);
});


$('#parts #addPage section .pages img').on('click',function(){
    let src = $(this).attr('src');
    $('#pageview img').attr('src',src);  
    $('#pageview').addClass('active');
});


$('#parts .closeviw').on('click',function(){
    $('#pageview img').attr('src','');  
    $('#pageview').removeClass('active');
});

/* ページ追加のプログラム
---------------------------------------------*/

