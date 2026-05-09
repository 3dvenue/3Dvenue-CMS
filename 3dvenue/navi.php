<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $submit = $_POST['submit'] ?? '';
    $html = $_POST['html'] ?? '';
    $map = $_POST['map'] ?? '';
    if($submit == 'admin'){
        file_put_contents('./inc/nav.txt', $html);        
    }

    if($submit == 'public'){
        file_put_contents('./inc/nav.txt', $html);        
        file_put_contents('../common/inc/nav.txt', $html);
        file_put_contents('../common/inc/map.txt', $map);
    }

}

include_once('../common/inc/dbcall.php');
$pages = [];
$sql = "SELECT * FROM pages";
$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages[] = $row;
}

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <!-- <meta property="og:image" content="https://あなたのドメイン/common/images/image_363be5.jpg"> -->
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/navigation.css?t=<?=time()?>">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body>
<div id="header">
<?php include_once('./inc/header.php')?>
</div>
<div id="nav">
<?php include_once('./inc/nav.php')?>
</div><!-- nav -->
<div id="main">

    <h2>ナビゲーションの編集</h2>

<div id="body">
    <header>
        <div class="inner">
            <?php include_once('../common/inc/header.txt')?>
        </div>
    </header>
    <nav>
        <div class="inner">
            <?php include_once('./inc/nav.txt')?>
            <!-- <div id="new">＋</div> -->
        </div>
    </nav>
    <main>

    <h2>ナビゲーションの編集</h2>
    <p style="line-height:1.8;">ナビゲーションの追加は[＋]ボタン、削除はキーボードの[Del]キー。<br>
        保存ボタンを押せば作業内容が記録されます。<br />
        作業内容を公開中のページに追加するには公開ボタンを押してください。
    </p>
    </main>
    <footer>
        <div class="inner">
            <?php include_once('../common/inc/footer.txt')?>
        </div>
    </footer>
</div><!-- #body-->

</div>
<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>


<div id="navieditor">
<h3></h3>
<div class="handle">Navigtion Editor</div>
<table>
    <tr><th>表示名</th><td><input type="text" name="name" id="name" value=""/></td></tr>
    <tr><th>Link先</th><td><select name="pid" id="pid">
        <?php foreach ($pages as $row) { ?>
            <option value="<?=$row['pid']?>"><?=$row['name']?></option>
        <?php } ?>
        <option value="0">外部リンク</option>
    </select></td></tr>
    <tr class="url"><th>url</th><td><input type="text" name="link" id="link" value="" placeholder="https://cms.3dvenue.jp" /></td></tr>
    <tr class="slug"><th>slug</th><td><input type="text" name="slug" id="slug" value=""/></td></tr>
    <tr><th>表示先</th><td><select name="target" id="target"><option value="_self">同じ場所で</option><option value="_blank">_blank</option><option value="sub">新しいタブ内に表示</option></select></td></tr>
    <tr>
        <td colspan="2" style="text-align: right;padding-right:5px">
            <div id="newtrash">
                <span id="newnav">＋</span>
                <span id="trash"><img src="./lib/trash.svg"></span>
            </div>
        </td>
    </tr>
</table>
</div>



<div id="bottomMenu">
    <div id="savebtn"><button id="admin">保存</button><button id="public">公開</button></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function(){

makeMap();

    function makeMap(){
        let map = '';
        $('nav ul li').each(function(){
            let p = $(this).attr('p') ?? '';
            if($.isNumeric(p)){
             let slug = $(this).children('a').attr('href').trim();
             map += p+','+slug+'\n';
            }
        })
        return map;
    }

    $('nav ul.nav2').remove();

    $(document).on('click','nav ul.nav0 > li',function(){
        $('nav ul.nav0 > li').removeClass('active');
        $(this).addClass('active');
        targetInfoGet($(this),'nav0');
        $('#navieditor').addClass('active');
        addPulus();
    })

    $(document).on('click','nav ul.nav1 > li',function(e){
        e.stopPropagation();
        let id = $(this).parent('ul').attr('id');
        if(id == 'plus'){
            $(this).attr('p','1');
            $(this).html('<a href="/NewChild/" target="_self">NewChild</a>');
            $('ul#plus').removeAttr('id');
        }

        $('nav ul.nav1 > li').removeClass('active');
        $(this).addClass('active');    
        targetInfoGet($(this),'nav1');
        $('#navieditor').addClass('active');
    })


    function addPulus(){
        let licount = $('ul.nav0 > li ul#plus').length;
        if(licount > 0){
            $('ul.nav0 > li ul#plus').remove();
        }
        $('ul.nav0 > li ul:not(:has(li))').remove();
        licount = $('ul.nav0 > li.active ul').length;
        if(licount == 0){
            $('ul.nav0 > li.active').append('<ul id="plus" class="nav1"><li>＋</li></ul>');
        }
    }

    $(document).on('keydown', function(e){        
        let nav = $('#navieditor').attr('data-nav');
        // 削除処理
        if(e.key === 'Delete'){
            $('ul.'+nav+' li.active').addClass('hidden');
            if(confirm('OKで完全削除します。キャンセルで残します。')){
                let licount = $('ul.'+nav+' li.active').parent().children('li').length;
                if(licount <= 1){
                    $('ul.'+nav+' li.active').parent('ul').remove();                    
                }else{
                    $('ul.'+nav+' li.hidden').remove();
                }
            }
        }

        // 復活処理
        if((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z'){
             $('ul.'+nav+' li.active').removeClass('hidden');
        }

        // 入力確定
        if(e.key === 'Enter' && $('#navieditor').find(':focus').length){
            $('#navieditor :focus').blur();
            e.preventDefault();
        }

    });



    $('#trash').on('click',function(){
        let nav = $('#navieditor').attr('data-nav');
        $('ul.'+nav+' li.active').addClass('hidden');
        if(confirm('OKで完全削除します。キャンセルで残します。')){
            let licount = $('ul.'+nav+' li.active').parent().children('li').length;
            if(licount <= 1){
                $('ul.'+nav+' li.active').parent('ul').remove();                    
            }else{
                $('ul.'+nav+' li.hidden').remove();
            }
        }
    })


    $('#newnav').on('click',function(){
        console.log('click');
        let nav = $('#navieditor').attr('data-nav');
        if(nav == 'nav0'){
            $('ul.nav0').append('<li p="1"><a href="/Newnavi/" target="_self">Newnavi</a></li>');
        }
        if(nav == 'nav1'){
            $('ul.nav0.active').css('background','red');
            $('ul.nav0 > li.active > ul.nav1').append('<li p="1"><a href="/NewChild/" target="_self">NewChild</a></li>');
        }

    })


    $('#new').on('click',function(){
        $('ul.nav0').append('<li p="1"><a href="/Newnavi/" target="_self">Newnavi</a></li>');
    })

    function targetInfoGet($this,nav){
      let p = $this.attr('p') ?? '0';
      let href = $this.children('a').attr('href');
      let target = $this.children('a').attr('target');
      let name = $this.children('a').text();
      if(p == '0'){
        // $('#slug').val('');
        $('#link').val(href);
      }else{        
        $('#slug').val(href);
        // $('#link').val('');
      }
      $('#name').val(name);
      $('#pid').val(p);
      $('#navieditor').attr('data-nav',nav);
      $('#target').val(target);
      $('#navieditor table').removeClass().addClass('p'+p);
    }

    $(document).on('click',function(e){
        if (!$(e.target).closest('nav,#navieditor').length) {
           $('nav ul li,#navieditor').removeClass('active');
           addPulus();
        }
    });

  $('ul.nav0').sortable({
    axis: 'x',            // 左右方向のみ
    cursor: 'move',       // つかんでいる時のマウスカーソル
    opacity: 0.7,         // ドラッグ中の透明度
    placeholder: 'ui-state-highlight', // 入れ替え先の隙間に表示される枠
    
    // ドラッグが終わった瞬間に実行される処理
    update: function(event, ui) {
      console.log('並べ替え完了！このままHTMLとして保存できます');
    }
  });

  $('ul.nav1').sortable({
    axis: 'y',            // 左右方向のみ
    cursor: 'move',       // つかんでいる時のマウスカーソル
    opacity: 0.7,         // ドラッグ中の透明度
    placeholder: 'ui-state-highlight', // 入れ替え先の隙間に表示される枠
    update: function(event, ui) {
      console.log('並べ替え完了！このままHTMLとして保存できます');
    }
  });

    $('ul.nav1').sortable({
        connectWith: '.nav1',
        placeholder: 'ui-sortable-placeholder',
        opacity: 0.8,
        update: function(event, ui) {
        }
    });

    $('#navieditor').draggable({
        handle: '.handle',
        containment: 'window',
        opacity: 0.8
    });

    $('#navieditor *').on('input',function(){
        let nav = $('#navieditor').attr('data-nav');
        let name = $('#name').val();
        let slug = $('#slug').val();
        let link = $('#link').val();
        let pid = $('#pid').val();
        let target = $('#target').val();
        if(pid == '0'){
            $('ul.'+nav+' li.active > a').attr('href',link);
        }else{
            $('ul.'+nav+' li.active > a').attr('href',slug);                       
        }
        $('ul.'+nav+' li.active > a').text(name);
        $('ul.'+nav+' li.active > a').attr('target',target);
        $('ul.'+nav+' li.active').attr('p',pid);
        $('#navieditor table').removeClass().addClass('p'+pid);
    })

    $('#savebtn button#admin,#savebtn button#public').on('click',function(){
      let map = makeMap();
      let navigation = $('#body nav .inner').clone(); // ←これでOK
      $(navigation).find('ul').removeClass('ui-sortable-handle ui-sortable');
      $(navigation).find('li').removeAttr('class');
      $(navigation).find('#new').remove();
      let submit = $(this).attr('id');
      $.post('navi.php',{
        html:navigation.html(),
        map:map,
        submit:submit
      })
      // console.log(navigation.html());
    })



});
</script>
</body>
</html>