/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$('#selectPage').val("<?=$pid?>");

let pname = $('#selectPage option:selected').text();
$('#changepagename').val(pname);

$('#editor .base div').on('click',function(){
    let id = $(this).data('id');
    $('#'+id).addClass('active');
})

$('#selectPage').on('change',function(){
    let p = $(this).val();
    location.href = "./editor.php?pid="+p;
})

$('#changename').on('click',function(){
    let pid = $('#selectPage').val();
    let newname = $('#changepagename').val();
    $.post('editor.php',{
        status:'changename',
        newname:newname,
        page:pid
    }).done(function(data) {
        $('#selectPage option[value="' + pid + '"]').text(newname);
    })
})