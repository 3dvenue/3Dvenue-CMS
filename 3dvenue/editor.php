<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {

    $page = $_POST['page'] ?? '';
    $status = $_POST['status'] ?? '';
    $newname = $_POST['newname'] ?? '';

    if(is_numeric($page) && $status == "preview"){
        $_SESSION['pageid'] = $page;
        echo 'success';
        exit;
    }

    if(is_numeric($page) && $status == "changename"){
        include_once('../common/inc/dbcall.php');
        $sql = "UPDATE pages SET name = :name WHERE pid = :pid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $newname,
            ':pid'  => $page
        ]);
        echo 'changename';
        exit;
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $cid = $_POST['cid'] ?? '';
    $pagename = $_POST['pagename'] ?? '';

    $page = $_POST['page'] ?? '';
    $status = $_POST['status'] ?? '';

    if(is_numeric($page) && $status == "preview"){
        $_SESSION['pageid'] = $page;

        echo $status;
        exit;
    }


if ($cid === '' || $pagename === '') {
    exit('必須項目が足りません');
}

if ($cid !== '' && $pagename !== '') {
        include_once('../common/inc/dbcall.php');
        
        $sql = "SELECT * FROM contents WHERE cid = " . $cid;
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $main = $row['dom'];

        $sql = "INSERT INTO pages (name, main) VALUES (:name, :main)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $pagename,
            ':main'  => $main
        ]);
      }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$pid = $_GET['pid'] ?? '1';
if (!is_numeric($pid)) {
    header('Location: index.php');
    exit;
}

include_once('../common/inc/dbcall.php');
$sql = "SELECT * FROM pages WHERE pid = ".$pid;
$stmt = $conn->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    header('Location: index.php');
    exit;
}

$name = $row["name"];
// $slug = $row["slug"];
$title = $row["title"];
$description = $row["description"];
$jsonld = $row["jsonld"];
$robots = $row['robots'];
$main = $row["main"];
$css = $row["css"];
$js = $row["js"];
$public = $row["public"];
$sdate = $row["sdate"];
$image = $row["image"];
$ld = $row["ld"];
$other = $row["other"];
$sitename = $row["sitename"] ?? '';

$file_path = '../index.php'; 
if (file_exists($file_path)) {
    $html = file_get_contents($file_path);
    preg_match('/<main[^>]*>(.*?)<\/main>/s', $html, $matches);
    if (isset($matches[1])) {
        $main_content = trim($matches[1]);
        $mainHTML = htmlspecialchars($main_content);
    }
}

$pages = [];
$sql = "SELECT * FROM pages";
$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages[] = $row;
}

// 追加するsection一括取得
$sql = "SELECT * FROM contents";
$stmt = $conn->query($sql);
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

$header = file_get_contents('../common/inc/header.txt');
$nav = file_get_contents('../common/inc/nav.txt');
$footer = file_get_contents('../common/inc/footer.txt');
$sitename = file_get_contents('../common/inc/sitename.txt');
$root = file_get_contents('../common/inc/root.txt');

$sns_img = '../common/img/snsimage'.$pid.'.webp';
$sns_img = file_exists($sns_img) ? $sns_img : '';


function domGet($url,$id){
    ob_start();
    include $url;
    $html = ob_get_clean();

    libxml_use_internal_errors(true);

    $dom = new DOMDocument();
    $dom->loadHTML($html);

    libxml_clear_errors();

    $x = new DOMXPath($dom);

    return $dom->saveHTML(
        $x->query("//*[@id='$id']")->item(0)
    );
}

include_once('./lang.php');
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($robots == "1") { ?>
    <meta name="robots" content="noindex,nofollow">
    <?php } ?>
    <meta name="description" content="<?=$description?>">
    <title><?=$title?></title>
    <meta property="og:title" content="<?=$title?>">
    <meta property="og:description" content="<?=$description?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?=$sitename?>">
    <meta property="og:locale" content="ja_JP">
    <?php if (!empty($meta_image)) { ?>
    <meta property="og:image" content="<?=$root?>common/img/<?=$meta_image?>">
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <?php } ?>
<?=$other?>
    <link rel="stylesheet" type="text/css" href="../common/css/style.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./common/css/color.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/editor.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/nav.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/e_parts.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/e_tag.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/e_text.css?t=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="./css/e_image.css?t=<?=time()?>">
    <link rel="icon" href="/favicon.ico">
    <style type="text/css" id="pagestyle">
        <?=$css?>
    </style>
</head>
<body>
<div id="body">
    <header>
        <div class="inner">
            <?=$header?>
            <div id="menubox"><label id="hamburger" for="menu"></label></div>
        </div>
    </header>
    <nav>
        <div class="inner">
        <input type="checkbox" name="menu" id="menu">
            <?=$nav?>
        </div>
    </nav>
    <main>
    <?=$main?>
    </main>
    <footer>
    <?=$footer?>
    </footer>
</div><!-- #body -->
<!----------- TOPMENU ----------->
<?php include_once('./inc/t_topmenu.php')?>
<!----------- TOPEDITOR ----------->
<?php include_once('./inc/e_master.php')?>
<!----------- CSS AND SCRIPT ----------->
<?php include_once('./inc/e_js_css.php')?>
<!----------- BASE MENEU ----------->
<?php include_once('./inc/e_base.php')?>
<!----------- TEXT MENEU ----------->
<?php include_once('./inc/e_text.php')?>
<!----------- TAG MENEU ----------->
<?php include_once('./inc/e_tag.php')?>
<!----------- FIGURE MENEU ----------->
<?php include_once('./inc/e_figure.php')?>
<!----------- IMAGE MENEU ----------->
<?php include_once('./inc/e_image.php')?>
<!----------- PARTS MENEU ----------->
<?php include_once('./inc/e_parts.php')?>
<!----------- IMAGEUPLOAD MENEU ----------->
<?php include_once('./inc/imageupload.php')?>

<div id="mainsave" class="btn"><?=$lang['update'][$lng]?></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){

const allParts = <?= json_encode($sections, JSON_UNESCAPED_UNICODE) ?>;
const sns_img = '<?=$sns_img?>';

    if(sns_img !== ''){
        $('#snsview').css('background-image','url('+sns_img+')');
    }

    $('#editHTML').on('click',function(){
        $('#html').addClass('active');
        let html = $('main section.active').html()
        $('#html textarea').val(html);
    })


    $('#view').on('click', function(){
        let page = $('#selectPage').val();
        $.post('editor.php', {
            page: page, 
            status: 'preview'
        }, function(data) {

        const html = "<?=$root?>preview/";
        popup = window.open(html, "preview", "width=1000,height=800,top=100,left=100");

        });
    });

    $('header,footer').on('click',function(){
        window.open('block.php','content');
    })

    $('#bodysize').on('input',function(){
        let scale = $(this).val();
        console.log(scale);
        $('#body').css({'transform':'scale('+scale+')'});
    })

    $('#topeditor #bgcolor input#c1').on('input',function(){
        let color = $('#c1').val();
         $('main section.active').css({'background':color});
    })

    $('#topeditor #bgcolor #colorreset').on('click',function(){
         $('main section.active').css({'background':''});
    })

    $('#html textarea').on('input',function(){
        let html = $('#html textarea').val();
        $('main section.active')[0].innerHTML = html;
    });

    $('#html .btn').on('click',function(){
        $('#html').removeClass('active');
    });

    // close button
    $('header .close').on('click',function(){
        $('#header').removeClass('active');        
    })

    $('.close').on('click',function(){
        $('body').removeClass('topeditor');
        $('.bottompopup').removeClass('active');
        $('.active').removeClass('active');
    })

    function cleanUp(){
        $('body').removeClass();
        $('main [contenteditable]').removeAttr('contenteditable');
    }

    $('main').on('click', 'section, section *', function(e) {
        cleanUp();
        e.stopPropagation(); // ここが防波堤

        if ($(e.target).is('span')) {
            $('section span').removeClass('active');
            $('#texteditor').removeClass().addClass('active');
            $(this).addClass('active');
            return;
         }

        $('.active').removeClass('active');
        $(this).addClass('active');
        let cla = $(this).attr('class');
        cla = cla.replace('active', '');
        let id = $(this).attr('id');
        var tag = this.tagName.toLowerCase();

       $('#tag').text(tag);
       $('#idname').val(id);
       $('#classname').val(cla);


        if (!$(this).is('section, figure, .inner, .content')) {
            $(this).attr('contenteditable', 'true').focus();
        }

        //sectionを選択
        if(tag == 'section'){
            $('body').addClass('topeditor');
            $('#selectmenu span').first().trigger('click');

            let bgi = $(this).css('background-image');
            $('#bgPreview').css({'background-image':bgi});
            console.log(bgi);
            $('#tageditor').removeClass('text');
        }

        if ($(this).is('div, h1, h2, h3, h4')) {
            let tagname = $(this).prop("tagName").toLowerCase();
            let classname = $(this).attr("class");
            $('#tagname').text(tagname);
            $('#t-class').val(classname);
            $('#tageditor').addClass('active');
        }

        if ($(this).is('figure')) {
            let tagname = $(this).prop("tagName").toLowerCase();
            let classname = $(this).attr("class");
            let alt = $(this).find('img').attr('alt');
            $('#alt').val(alt);
            $('.tagname').text(tagname);
            $('#f-class').val(classname);
            $('#figureeditor').addClass('active');
        }

        if ($(this).is('.pdf .pdfimage img')) {
                $(this).closest('.pdfflex').addClass('active');
                $('#pdflist').addClass('active');
        }

    });

    $('main').on('keydown click','section, section *', function(e) {
           $('#mainsave').addClass('click');
    });

    $('header,nav,footer').on('click',function(){
        $('main section').removeClass('active');
        $('body').removeClass('active');
        $('#sideeditor').removeClass('active');
    });

    $('#selectmenu span').on('click',function(){
        $('#topeditor .inner > div').removeClass('active');
        const left  = $(this).position().left
        const width = $(this).outerWidth();
        $(this).data('name');
        $('#selectmenu #underbar').css({'width':width+'px','left':left+'px'});
        let name = $(this).data('name');
        $('#topeditor .inner > div#'+name).addClass('active');
    })

    $('#mainsave').on('click',function(){
        const $clone = $('<div>').append($('main').contents().clone());
        $clone.find('[contenteditable]').removeAttr('contenteditable');
        $clone.find('.active').removeClass('active');

        const html = $clone.html().trim(); 

            $.post('sqlupdate.php', {
                pid: '<?=$pid?>',
                table: 'pages',
                column: 'main',
                data: html
            }, function(res){
                console.log(res);
         });
        $(this).removeClass('click');
    })


    $('.codearea').on('keydown', function(e) {
        const el = e.target;

        if (e.key === 'Tab') {
            e.preventDefault();
            el.setRangeText("\t", el.selectionStart, el.selectionEnd, 'end');
        } 
        else if (e.key === 'Enter') {
            const line = el.value.substring(el.value.lastIndexOf('\n', el.selectionStart - 1) + 1, el.selectionStart);
            const indent = line.match(/^\s+/);

            if (indent) {
                e.preventDefault();
                el.setRangeText('\n' + indent[0], el.selectionStart, el.selectionStart, 'end');
            }
        }
    });

    $(window).on('keydown', e => {
      const s = $('main section.active');
      if (e.ctrlKey || e.metaKey) {
          if (e.key === 'ArrowUp') s.insertBefore(s.prev('section'));
          if (e.key === 'ArrowDown') s.insertAfter(s.next('section'));
      }
    });


<?php
include_once "./js/e_master.js";
include_once "./js/e_base.js";
include_once "./js/e_js_css.js";
include_once "./js/e_tag.js";
include_once "./js/e_text.js";
include_once "./js/e_parts.js";
include_once "./js/e_figure.js";
include_once "./js/imageupload.js";
?>
})
</script>
<script src="./js/nav.js?t=<?=time()?>"></script>
</body>
</html>