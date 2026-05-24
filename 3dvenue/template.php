<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tid = $_POST['tid'] ?? '';
    $mode = $_POST['db'] ?? '';
    $tname = $_POST['tname'] ?? '新規テンプレート';
    $css = $_POST['css'] ?? '';
    $status = $_POST['status'] ?? '';
    $now = date('Y-m-d H:i:s');

    include_once('../common/inc/dbcall.php');

    if($status == 'finish'){
        file_put_contents('../common/css/style.css', $css);
    }

    if ($mode == 'add') {
        $sql = "INSERT INTO templates (tname, css, memo) VALUES (:tname, :css, :memo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':tname' => $tname,
            ':css' => $css,
            ':memo' => $now
        ]);
    }

    if ($mode == 'update') {
        $sql = "UPDATE templates SET tname = :tname, css = :css, memo = :memo WHERE tid = :tid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':tname' => $tname,
            ':css' => $css,
            ':memo' => $now,
            ':tid' => $tid
        ]);
    }

    if ($mode == 'del') {
        $sql = "DELETE FROM templates WHERE tid = :tid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':tid' => $tid]);
    }

    echo "ok";
    exit;
}

$pid = 1;

include_once('../common/inc/dbcall.php');
$sql = "SELECT * FROM pages WHERE pid = ".$pid;
$stmt = $conn->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    header('Location: index.php');
    exit;
}

$name = $row["name"];
$title = $row["title"];
$description = $row["description"];
$main = $row["main"];
$css = $row["css"];
$js = $row["js"];
$public = $row["public"];
$sdate = $row["sdate"];
$image = $row["image"];
$ld = $row["ld"];
$other = $row["other"];

// mainの中身を取り出す
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


$templates = [];
$sql = "SELECT * FROM templates";
$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $templates[] = $row;
}

$default = $templates[0];

$header = file_get_contents('../common/inc/header.txt');
$color = file_get_contents('./common/css/color.css');
$footer = file_get_contents('../common/inc/footer.txt');
$nav = file_get_contents('../common/inc/nav.txt');

include_once('./lang.php');

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title><?=$title?>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/template.css?t=<?=time()?>">
<style>

#main {
    min-height: calc(100vh - 300px);
    padding:0;
}

#body{
    transform: scale(0.8);
    transform-origin: top center;
    border:1px solid #CCC;
    box-shadow:3px 3px 10px #0003;
}

#changeTemplate{
    display: flex;
    justify-content: center;
    align-items: center;
    gap:20px;
    margin-bottom:30px;
}

#selecter{
    padding:5px 20px;
    border-radius: 10px;
    border-color:#D3E3FC;
}

#cssEditor{
    position: fixed;
    bottom:0;
    left: 0;
    width: 100%;
    height: 100px;
    padding: 0;
    background: #EDF2FA;
    border: 1px solid #D3E3FC;
    text-align: right;
}

#cssEditor h3{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 500;
    height: 25px;
    padding: 0px 20px 0;
    cursor: pointer;
    border-bottom: none;
    font-weight: 500;
    box-sizing: border-box;
    margin: 0;
    border: 1px solid;
    border-color: #fff #ccc #ccc #eee;

}

#cssEditor textarea#css{
    width: 100%;
    height: calc(100% - 60px);
    padding: 10px 20px;
    border: 1px solid #D3E3FC;
    line-height: 1.2;
    resize: none;
    font-size: 14px;
    font-family: Consolas;
    background: #303841;
    color: #EEF;
    tab-size: 4;
}

#cssEditor span.hadle {
    position: absolute;
    top: -5px;
    left:0;
    display: block;
    height: 10px;
    width: 100%;
    cursor: ns-resize;
    user-select: none;
}

#savebtn{
    display: flex;
    justify-content: center;
    align-items: center;
    gap:20px;
    height:35px;
    margin-top:-8px;
    line-height: 1.0;
}

#savebtn button{
    font-size:12px;
    padding:3px 20px;
    border-radius: 3px;
    border:1px solid #D3E3FC;
    cursor: pointer;
    color:#FFF;
    background:#10AAA1;
}

#savebtn input{
    font-size:12px;
    padding:3px 10px;
    border-radius: 3px;
    border:1px solid #D3E3FC;
}

#savebtn button:hover{
    border:1px solid #0F57CB;
}

#savebtn #del{
    display: flex;
    align-items: center;
    cursor: pointer;
}


</style>
</head>
<body>
<div id="main">
<div class="inner">
<h2><?=$lang['template_edit'][$lng]?></h2>

<div id="changeTemplate">
    <select id="selecter">
    <?php foreach ($templates as $t) { ?>
        <option value="<?=$t['tid']?>"><?=$t['tname']?></option>
    <?php } ?>
    </select>

<input type="range" id="scale" min="30" max="100" step="1" value="80">
    <div class="scale"><span>80</span>%</div>
</div>

<style type="text/css" id="color"><?=$color?></style>
<style type="text/css" id="pagestyle"><?=$css?></style>
<style type="text/css" id="template"><?= $default['css'] ?></style>

<div id="body">
<header>
    <div class="inner">
        <?=$header?>
    </div>
    <div id="menubox"><label id="hamburger" for="menu"><div id="menuicon"></div></label></div>
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
</div><!-- body -->

</div>
</div><!--- main-->

<div id="cssEditor">
<span class="hadle"></span>
<h3>Template CSS</h3>
<textarea id="css"><?= $default['css'] ?></textarea>
    <div id="savebtn">
        <input type="text" id="tname" value="<?= $default['tname'] ?>">
        <input type="checkbox" id="status" value="finish">
        <button value="add"><?=$lang['add'][$lng]?></button>
        <button value="update"><?=$lang['update'][$lng]?></button>
        <button value="del"><?=$lang['del'][$lng]?></button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function(){

    const data = <?= json_encode($templates) ?>;

    $('#selecter').on('change',function(){
        const tid =$('#selecter').val();
        selecterChange(tid);
    })


function selecterChange(tid){
      const selectedId = tid;
      const tname = $('#selecter').find('option:selected').text();
      const target = data.find(t => t.tid == selectedId);
      const css = target ? target.css : '';
      $('#template').text(css);
      $('#cssEditor textarea#css').val(css);
      $('#cssEditor #tname').val(tname);
}

    $('span.hadle').on('mousedown', function(e) {
        console.log('mousedows');
        e.preventDefault();
        let targetPopup = $(this).closest('#cssEditor');
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

    // 1. Tabキーでインデントを入れる（エディタの挙動）
    $('#css').on('keydown', function(e) {
        const el = e.target; // jQueryのイベントオブジェクトから要素を引く

        if (e.key === 'Tab') {
            e.preventDefault();
            // 選択範囲を "\t" で置き換える（バニラだけど最強に速い）
            el.setRangeText("\t", el.selectionStart, el.selectionEnd, 'end');
        } 
        else if (e.key === 'Enter') {
            const line = el.value.substring(el.value.lastIndexOf('\n', el.selectionStart - 1) + 1, el.selectionStart);
            const indent = line.match(/^\s+/);

            if (indent) {
                e.preventDefault();
                // 改行＋インデントを流し込む
                el.setRangeText('\n' + indent[0], el.selectionStart, el.selectionStart, 'end');
            }
        }
    });


    $('#css').on('input',function(){
        let css = $(this).val();
        console.log(css);
        $('#template').text(css);
    })

    $('#cssEditor button').on('click',function(){
       let db = $(this).val();
       let tname = $('#tname').val();
       let tid = $('#selecter').val();
       let css = $('#css').val();
       let status = $('#status:checked').val();
       $.post('template.php',{
            tid:tid,
            db:db,
            tname:tname,
            css:css,
            status:status
       }, function(data) {
            console.log('サーバーからの応答:', data);
            if(data === "ok") {
                location.href = 'template.php?t=' + tid;
            }
       })
    })

    if (tid = "<?= $_GET['t'] ?? '' ?>"){
         $('#selecter').val(tid);
        selecterChange(tid);        
    }


    $('#bodysize').on('change',function(){
        let size = $(this).val();
        $('#body').css({'transform':'scale('+size+')'});
    })    

    $('#scale').on('input',function(){
        let scale = $(this).val();
        $('.scale span').text(scale);
        size = scale / 100;
        $('#body').css({'transform':'scale('+size+')'});
    })    


})
</script>

</body>
</html>