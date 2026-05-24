/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$('#tools div').on('click',function(){
    $('.bottompopup').removeClass('active');
    $('#tools div').removeClass();
    $(this).addClass('active');
    let id = $(this).attr('id');
        switch (id) {
           case 'scriptBtn':
            $('#js').addClass('active');
        break;
        case 'styleBtn':
            $('#css').addClass('active');
        break;
    }
    $('body').removeClass();
    $('#sideeditor').removeClass('active');     
})

//Stylesheetを即時反映
$('#css textarea').on('input', function(e) {
        $('#pagestyle').text($(this).val());
});

//Stylesheetの保存
$('#css .btn').on('click',function(){
    let css = $('#css textarea').val();
        $.post('sqlupdate.php', {
            pid: '<?=$pid?>',
            table: 'pages',
            column: 'css',
            data: css
        }, function(res){
            $('#css').removeClass('active');
     });
})


$('#js .btn').on('click',function(){
    let js = $('#js textarea').val();
        $.post('sqlupdate.php', {
            pid: '<?=$pid?>',
            table: 'pages',
            column: 'js',
            data: js
        }, function(res){
            $('#js').removeClass('active');
     });
})


$('span.hadle').on('mousedown', function(e) {
    e.preventDefault();
    let targetPopup = $(this).closest('.bottompopup');
    $(document).on('mousemove.resizer', function(moveEvent) {
        let h = $(window).height() - moveEvent.clientY;        
        if (h > 100 && h < $(window).height() * 0.95) {
            targetPopup.css('height', h + 'px');
        }
    });
    $(document).one('mouseup', function() {
        $(document).off('mousemove.resizer');
    });
});
