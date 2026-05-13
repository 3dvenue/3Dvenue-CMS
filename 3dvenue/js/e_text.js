/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

// 設定をクリアしてテキストだけに戻す
$('#texteditor .close').on('click',function(){
    cleanUp();
    $('#tageditor').removeClass('text');
    $('#texteditor').removeClass('link');
})

$(document).on('click', '#clearSpan', function() {
    $('span.active').contents().unwrap();    
    $('#texteditor').removeClass('active');
});

$(document).on('click', '#clearLink', function() {
    $('a.active').contents().unwrap();    
    $('#texteditor').removeClass('active');
});

$('#f-family').on('input',function(){
    let style = $(this).val();
    $('section span.active').css({'font-family':style});
})

$('#f-color').on('input',function(){
    let color = $(this).val();
    $('section span.active').css({'color':color});
})

$('#f-size').on('input',function(){
    let fsize = $(this).val();
    $('section span.active').css({'font-size':fsize+'px'});
})

$('#f-weight').on('change',function(){
    let width = $(this).val();
    $('section span.active').css({'font-weight':width});
})

// contenteditable属性を持つ要素（divなど何でもOK）を対象にする
$('[contenteditable="true"]').on('paste', function() {
    const $this = $(this);
    
    setTimeout(function() {
        // その中に入り込んだ「すべてのspan」からstyle属性を消す
        $this.find('span').removeAttr('style');
    }, 10);
});

// 選択した文字をspanで囲う
$('#editStart').on('click',function(){
    $('#texteditor').removeClass().addClass('active');
    wrapTag();
})

// 選択した文字をaで囲う
$('#LinkStart').on('click',function(){
    $('#texteditor').removeClass().addClass('link');
    wrapLink();
})

function wrapTag(newText) {
    const addSpan = '<span class="active">'+selectText+'</span>';
    const $span = $(addSpan);
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    range.deleteContents();
    range.insertNode($span[0]);
    selection.collapseToEnd();
}

function wrapLink(newText) {
    const addLink = '<a href="/" class="active">'+selectText+'</a>';
    const $link = $(addLink);
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    range.deleteContents();
    range.insertNode($link[0]);
    selection.collapseToEnd();
}

function hasTextSelection() {
    const sel = window.getSelection();
    if (!sel) return false;
    return !sel.isCollapsed;
}

let selectText = "";

$(document).on('keyup mouseup','main section *', function(e) {
    let tagname = e.target.tagName;
    if (hasTextSelection()) {
        $('#texteditor').removeClass();
    selectText = window.getSelection().toString();
        $('#tageditor').addClass('text');
        $('#texteditor').addClass('text');
    }else{
        // console.log(tagname);
            $('main section *.active').removeClass('active');
        if(tagname == "SPAN"){
            $('#tageditor').addClass('text');
            $('#texteditor').removeClass().addClass('text');
            return;
        }

        if(tagname == "A"){
            let href = $(this).attr('href');
            $('#link').val(href);
            $('#texteditor').removeClass().addClass('link');
            return;
        }

        $('#texteditor').removeClass('text');
        $('#tageditor').removeClass('text');
    }
});

$('#linkSet').on('click',function(){
   let href = $('#link').val();
    console.log(href);
   $('main section a.active').attr('href',href);
})
