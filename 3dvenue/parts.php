<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');
$tid = (int)($_GET['t'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit = $_POST['submit'] ?? '';
    $cid    = $_POST['cid'] ?? '';
    $type   = $_POST['type'] ?? '0';
    $cname  = $_POST['cname'];
    $dom    = $_POST['dom'];
    $memo   = $_POST['memo'];
    $publish   = $_POST['publish'];
    $cimage = $_POST['cimage'] ?? ''; // JSから届くBase64データ

    $saveImage = function($id, $base64Data) {
        if (!$base64Data) return;  
        $img = str_replace('data:image/webp;base64,', '', $base64Data);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        $targetPath = "./parts/{$id}.webp"; 
        file_put_contents($targetPath, $fileData);
    };

    if ($submit === 'add') {
        $sql = "INSERT INTO contents (type, cname, dom, memo) VALUES (:type, :cname, :dom, :memo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':type'  => $type,
            ':cname' => $cname,
            ':dom'   => $dom,
            ':memo'  => $memo
        ]);
        
        // 【重要】新規作成されたIDを取得して画像を保存
        $newId = $conn->lastInsertId();
        $saveImage($newId, $cimage);
    }

    if ($submit === 'edit') {
        $sql = "UPDATE contents SET cname = :cname, type = :type, dom = :dom, memo = :memo WHERE cid = :cid";            
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':type'  => $type,
            ':cname' => $cname,
            ':dom'   => $dom,
            ':memo'  => $memo,
            ':cid'   => $cid
        ]);
        
        // 既存のIDで画像を上書き保存
        $saveImage($cid, $cimage);
    }

    if ($submit === 'del') {
        $sql = "DELETE FROM contents WHERE cid = :cid";            
        $stmt = $conn->prepare($sql);
        $stmt->execute([':cid' => $cid]);
        
        // 削除時は画像も消しておくとストレージが汚れない
        $targetPath = "./parts/{$cid}.webp";
        if (file_exists($targetPath)) unlink($targetPath);
    }

    header('Location: ' . $_SERVER['PHP_SELF']. '?t=' . $type); 
    exit;
}

$sql = "SELECT * FROM contents WHERE Type < 3 ORDER BY cname";
$stmt = $conn->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once('./lang.php');
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <style>
    body{
        min-width:300px;
    }

    #main{
        min-height:calc(100vh - 50px);
    }

    #main .inner h2{
        display: flex;
        justify-content:space-between;
        position: relative;
        padding-right:60px;
        gap:40px;
        height:65px;
    }

    #selectparts{
        padding:0 20px;
        font-size:18px;
        font-weight:500;
        color:#333;
        border-radius:10px;
        height:40px;
    }

    @media(max-width:680px){
        #main .inner h2 #new,
        #main .inner h2 #sampleaccet,
        #main .inner h2 #selectparts{
            display: none;
        }
    }


    .btn{
        background:#F4603D;
    }

    /* section
    ---------------------------------------------*/
    section div.flex{
        flex-wrap: wrap;
        display: grid;
        gap: clamp(10px, 10vw, 20px);
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    section div.flex div.parts{
        width:100%;
        max-width:240px;
    }

    section div.flex div.parts img{
        border:1px solid #CCC;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    section div.flex div.parts img:hover{
        outline:1px solid #333;
        cursor: pointer;
    }


    #pages .flex .parts .image{
        aspect-ratio: 1/1;
    }

    pages .flex .parts .image img{
        width:100%;
        height:100%;
        object-fit: contain;
    }


    #main section{
        display: none;
    }

    #main section.active{
        display: block;
    }


    /* editor
    ---------------------------------------------*/
    #headerandfooter,
    #editor{
        position: fixed;
        top:0;
        left:0;
        width:100%;
        height:100vh;
        background:#000C;
        display: flex;
        justify-content: center;
        align-items:baseline;
        padding:40px 20px;
        transform: scale(0.0);
        opacity:0;
        pointer-events: none;
        transition-duration: .5s;
        min-width:300px;
    }

    #headerandfooter.active,
    #editor.active{
        transform: scale(1.0);
        opacity:1.0;
        pointer-events: auto;
    }

    #headerandfooter .close,
    #editor .close{
        background:#3d5d99;
        font-weight: 700;
    }

    #editor .close{
        top:20px;
        right:20px;
        z-index:1000;
    }

    #editor #view{
        width:100%;
        /*max-width:1260px;*/
        height:auto;
        min-height:60px;
        /*border:1px solid #333;*/
        /*transform-origin: top left;*/
        background:#FFF;
    }

    #editor #form{
        position:relative;
        padding:40px 20px 120px;
        width:800px;
        overflow:hidden;
    }

    #editor form{
        position:fixed;
        bottom:0;
        left:0;
        width:100%;
        max-height:calc(100vh - 200px);
        padding:0 2px 0;
        background:#EDF2FA;
        border:1px solid #D3E3FC;
        height:400px;
        z-index: 100;
    }

    #editor form span.hadle{
        position: absolute;
        top: -5px;
        left: 0;
        display: block;
        height: 10px;
        width: 100%;
        cursor: ns-resize;
        user-select: none;
    }

    #editor form h3 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 500;
        height: 25px;
        padding: 0px 10px 0;
        cursor: pointer;
        border-bottom: none;
        font-weight: 500;
        box-sizing: border-box;
        margin: 0;
        border: 1px solid;
        border-color: #fff #ccc #ccc #eee;
    }

    #editor form #domarea{
        height:calc(100% - 75px);
        padding:0;
    }

    #editor #form textarea{
        width:100%;
        height:100%;
        padding:3px 10px;
        border:1px solid #ccc;
        font-family: Consolas;
        background: #303841;
        color: #EEF;
        tab-size: 4; /* 8から4へ（または2へ） */
    }

    #editor #inputarea{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding:0 20px;
        height:50px;
    }

    #editor #input{
        display: flex;
        justify-content: left;
        align-items: center;
        font-size:14px;
        gap:20px;
    }

    #editor #input div{
        display: flex;
        align-items: center;
    }

    #editor #input div.memo{
        display: none;
    }


    #editor #input div label{
        display: flex;
        align-items: center;
        gap:5px;
    }

    #editor #input div label span{
        /*width:60px;*/
    }

    #editor.new #edit,
    #editor.new #dell{
        display:none;
    }

    #editor.edit #add{
        display: none;
    }

    #editor select{
        padding:3px 10px;
        border-radius: 5px;
        border:1px solid #ccc;
    }

    #editor input[type="text"]{
        padding:3px 10px;
        border-radius: 5px;
        border:1px solid #ccc;
        box-sizing: border-box;
        width:150px;
    }

    #editor #form form > label span,
    #editor #form form > label{
        display: block;
    }

    #editor #form form > label{
        margin-bottom:10px;
    }

    #editor #submit{
        display: flex;
        justify-content: right;
        gap:20px;
    }

    #editor #submit label{
        display: flex;
        align-items: center;
        gap:5px;
    }

    #editor a.button1,
    #editor a.button2{
        display:flex;
        justify-content: center;
        align-items: center;
        padding:0 20px;
        height:40px;
        text-decoration: none;
        width:max-content;
        border-radius: 20px;
        margin: 0 auto;
    }

    /* wrapper
    ---------------------------------------------*/

    #wrapper{
        position: fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        z-index:10;
    }

    #view header{
        padding:10px 0;
    }

    #view footer{
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height:60px;
        background:#666;
    }

    #view footer *{
        color:#EEF;
    }

    #view header .inner{
        max-width:1040px;
        padding:0 20px;
        margin:0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #view header .inner #logo{
        height:50px;
        width:50px;
    }

    #view header .inner #logo img{
        height:100%;
        width:100%;
        object-fit: contain;
    }

    #view header .inner #headertext{
        font-weight: 700;
    }

    #checkimage{
        width:100%;
        height:auto;
        max-height:400px;
        display: none;
    }

    #checkimage img{
        width:100%;
        height:auto;
        max-height:400px;
        object-fit: contain;
    }

    /* pageeditor
    ---------------------------------------------*/
    #pageeditor{
        position: fixed;
        top:0;
        left:0;
        width:100%;
        height:100vh;
        background:#000C;
        display: flex;
        justify-content:left;
        align-items: center;
        transform: scale(0.0);
        opacity:0;
        pointer-events: none;
        transition-duration: .5s;
    }

    #pageeditor.active{
        transform: scale(1.0);
        opacity:1.0;
        pointer-events:auto;
    }

    #pageeditor #move{
        position:fixed;
        right:20px;
        top:40%;
        background:#EDF2FA;
        font-size:12px;
        padding:10px;
        border-radius: 5px;
        box-shadow: 3px 3px 7px #0003;
        border:1px solid #D3E3FC;
    }

    #pageeditor #move div{
        display: flex;
        align-items: center;
        gap:10px;
        margin-bottom:20px;
        background:#FFF9;
        padding:5px;
        border:1px solid #D3E3FC;
        border-radius:5px;
    }

    #pageeditor #move span{
        font-size:12px;
        line-height: 1.2;
    }

    #pageeditor #move span.mbtn{
        display: flex;
        justify-content: center;
        align-items: center;
        width:30px;
        height:30px;
        border-radius:5px;
        border:1px solid #D3E3FC;
        cursor: pointer;
        background:#FFF;
        font-size:10px;
    }

    #pageeditor #move span.mbtn img{
        width:50%;
        height:auto;
    }

    #pageeditor #move span.mbtn:hover{
        background:#9CF;
    }

    #pageeform{
        width:100%;
        height:100vh;
        display: flex;
        justify-content:left;
        gap:5px;
        padding:20px;
        background:#FFF3;
    }

    #pageesections{
        padding:20px;
        background:#ccc;
        width:200px;
        overflow-y:auto;
        height:100%;
    }

    #pageesections .parts{
        display: flex;
        line-height: 1.0;
        flex-direction: column;
        padding-bottom:10px;
    }

    #pageesections .name{
        font-size:12px;
        width:max-content;
        background:#FFF;
        padding:0 10px;
        border-radius: 0 5px 0 0;
    }

    #pageesections .image{
        cursor: pointer;
    }

    #pageesections .image:hover{
        outline:2px solid #333;
    }

    #pageesections img{
        width:100%;
    }


    #siteimage{
        position: relative;
        width:calc(100% - 430px);
        display: flex;
        justify-content: center;
    }

    #pageeform form{
        background:#CCC;
        width:200px;
        height:100%;
        padding:20px;
    }

    #pageeform form #pinput{
        margin-bottom:20px;
    }

    #pageeform form #pinput > div{
        width:100%;
    }

    #pageeform form #pinput label span{
        display: block;
    }

    #pageeform form #psubmit > div{
        margin-bottom:20px;
    }

    #pageeform input{
        padding: 3px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        width:100%;
        line-height: 1.0;
    }


    #pageeform #pdom{
        width:100%;
        height:10rem;
        display: none;
    }

    #pageeform #pagePreview{
        border:1px solid #FFF;
        width:160px;
        height:260px;
        background-size:contain;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }

    /* sampleurl
    ---------------------------------------------*/
    #sampleurl{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100vh;
        background: #1A2433dd;
        padding:20px;
        transform: scale(0.0);
        pointer-events: none;
    }

    #sampleurl h2{
        margin-bottom:20px;
        color:#EEF;
    }

    #sampleurl.active{
        transform: scale(1.0);
        pointer-events: auto;
    }

    #sampleurl .inner{
        border:1px solid #ccc;
        padding:30px;
        overflow-y:auto;
        display: grid;
        gap: clamp(10px, 10vw, 20px);
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        height:calc(100vh - 100px);
        border-radius: 10px;
        background: #FFF;
    }

    #sampleurl .inner .svg{
        cursor: pointer;
        width:100%;
        aspect-ratio: 1/1;
        user-select: none;
    }


    #sampleurl .inner .svg img{
        width:100%;
        height:100%;
        object-fit: contain;
    }

    /* #body
    ---------------------------------------------*/

    #body{
        width:100%;
        height:100%;
        background:#FFF;
        overflow-y:auto;
        transform: scale(calc(100% / 1));
        transform-origin: top center;
    }

    #body .close{
        opacity:0;
    }

    #body.maxwidth{
        position:fixed;
        top:0;
        left:0;
        width:100% !important;
        height:100% !important;
        transform: scale(calc(100% / 1)) !important;
    }

    #body.maxwidth .close{
        opacity:1;
    }

    #body header,
    #body nav,
    #body main,
    #body footer{
        pointer-events: none;
    }

    #body main section{
        cursor: pointer;
        pointer-events: auto;
    }

    #body main section:hover{
        outline: 2px solid #333;
    }

    #body main section.active{
        outline:2px solid #333;
        outline-offset: -2px;
    }

    /* #body
    ---------------------------------------------*/

    /* header
    -------------------------------------------*/
    #body header{
        line-height: 1.0;
        padding:10px 0;
        border-bottom:1px solid #666;
        height:80px;
    }

    #body header .inner{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #body header #logo{
        margin:0;
    }

    #body header #logo img{
        height:60px;
        width:auto;
    }

    #body header h1{
        line-height: 1.0;
        padding:0;
        margin:0;
        font-size:1.5rem;
        color:#1847A1;
    }

    /* nav
    -------------------------------------------*/

    #body nav{
        background:#1847A1;
    }

    #body nav ul{
        display: flex;
        list-style: none;
        justify-content:space-between;
    }


    #body nav ul li{
        flex:auto;
    }

    #body nav ul li a{
        display:flex;
        height:40px;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color:#fff;
        font-weight: 500;
    }


    /* main
    -------------------------------------------*/

    #body main {
        min-height:calc(100% - 180px);
        padding:0;
    }

    #body main h2{
        padding-bottom:20px;
        color:#00284a;
    }

    #body main section{

    }

    #body main section h3{
        width:100%;
        margin-bottom:20px;
    }

    #body main section .columarea{
        display: flex;
        gap:40px;
    }

    #body main section .columarea > * {
        flex:1;
    }

    #body main section .imagebox figure img{
        width:100%;
        height:auto;
    }

    /* footer 
    -------------------------------------------*/

    #body footer{
        height:60px;
        padding:20px;
        text-align: center;
        background:#012848;
        font-size:14px;
        color:#666;
    }

    #body footer *{
        color:#FFF;
    }
            
    </style>
</head>
<body>
<div id="main">
<div class="inner">
<h2><span><?=$lang['parts_edit'][$lng]?></span>

<select id="selectparts">
    <option data-cid="0" value="sections">Section Parts</option>
    <option data-cid="1" value="elements">Element Parts</option>
    <option data-cid="2" value="pages">Web Pagedesign</option>
</select>

<div><button id="sampleaccet" class="btn">Assets</button></div>

<div class="btn" id="new">＋</div>
</h2>

<section id="sections" class="active" data-tid="0">
    <h3>Section Parts</h3>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '0'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>
</section>

<section id="elements" data-tid="1">
    <h3>Element Parts</h3>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '1'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>
</section>

<section id="pages" data-tid="2">
    <h3>Web Pagedesign</h3>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '2'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>
</section>

</div>
</div><!-- #main -->

<div id="editor">
    <div class="close">✕</div>
    <div id="form">
        <div id="wrapper"><div id="view"></div></div>
        <div id="checkimage"><img src="lib/image.svg"></div>

        <form method="POST" action="parts_to_thum.php">
        <span class="hadle"></span>
        <h3>HTML</h3>
        <div id="domarea">
            <textarea name="dom" id="dom"></textarea>
        </div>
        <div id="inputarea">
            <div id="input">
                <input type="hidden" id="cimage" name="cimage">
                <input type="hidden" id="cid" name="cid" />
                <div>
                    <label>
                        <select id="type" name="type">
                            <option value="0">Section</option>
                            <option value="1">Element</option>
                        </select><span>：Type</span>
                    </label>
                </div>
                <div><label><input type="text" id="cname" name="cname" /><span>：Name</span></label></div>
                <div class="memo"><label><input type="text" name="memo" id="memo" value=""><span>：MEMO</span></label></div>
            </div><!-- input -->

            <div id="submit">
                <button type="submit" id="edit" class="btn" name="submit" value="edit"><?=$lang['save'][$lng]?></button>
                <button type="submit" id="add" class="btn" name="submit" value="add"><?=$lang['add'][$lng]?></button>
                <button type="submit" id="dell" class="btn" name="submit" value="del"><?=$lang['del'][$lng]?></button>
            </div><!-- submit -->
        </div>
        </form>
    </div><!-- form -->
</div><!-- editor-->

<div id="pageeditor">
<div class="close">✕</div>
<div id="pageeform">
    <form method="POST">
        <input type="hidden" id="pimage" name="cimage">
       <div id="pinput">
            <input type="hidden" id="ptype" name="type" value="2">
            <input type="hidden" id="pcid" name="cid" value="" />
            <div><label><span>Name：</span><input type="text" id="pname" name="cname" required></label></div>
        </div><!-- input -->
        <div id="psubmit">
            <div><button type="submit" id="padd" class="btn" name="submit" value="add"><?=$lang['add'][$lng]?></button></div>
            <div>
                <button type="submit" id="pedit" class="btn" name="submit" value="edit"><?=$lang['save'][$lng]?></button>
                <button type="submit" id="pdell" class="btn" name="submit" value="del"><?=$lang['del'][$lng]?></button>
            </div>
            <div>
                <input type="range" id="psize" max="400" min="100" step="1" value="100">
                <button type="button" id="reset"><?=$lang['reset'][$lng]?></button> <button type="button" id="maxwidth"><?=$lang['fullsize'][$lng]?></button>
            </div>
                <textarea name="dom" id="pdom"></textarea>
                <div id="pagePreview"></div>
        </div><!-- submit -->
    </form>

    <div id="pageesections">
    <?php foreach ($rows as $row): ?>
        <?php if ($row['type'] == '0'): ?>
            <div class="parts element" data-cid="<?= $row['cid'] ?>">
                <div class="name"><?= $row['cname'] ?></div><div class="image"><img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>"></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    </div><!-- minisections-->


    <div id="siteimage">
        <div id="body">
            <div class="close">✕</div>
            <header>
                <div class="inner">
                <div id="logo"><img src="../common/img/logo.webp"></div>
                <div id="headertext">Digital Dream Deliver</div>
                </div>
            </header>
            <nav>
                <div class="inner">
                    <ul class="nav0">
                        <li p="1"><a href="/" target="_self">HOME</a></li>
                        <li p="2"><a href="/service/" target="_self">SERVICE</a>
                        <li p="1"><a href="/project/" target="_self">PROJECT</a>
                        <li p="1"><a href="/about/" target="_self">ABOUT</a></li>
                        <li p="1"><a href="/news/" target="_self">NEWS</a>
                        <li p="1"><a href="/contact/" target="_self">CONTACT</a></li>
                    </ul>
                </div>
                </nav>
            <main></main>
            <footer>
                <div id="copyright">&copy;3dvenue.jp</div>
            </footer>
        </div>
    </div>
</div><!-- pageform -->

<div id="move">
    <div id="up"><span class="mbtn">▲</span></div>
    <div id="down"><span class="mbtn">▼</span></div>
    <div id="clear"><span class="mbtn">Esc</span></div>
    <div id="trash"><span class="mbtn">Del</span></div>
</div>
</div><!-- pageeditor-->


<div id="sampleurl">
    <div class="close">×</div>
    <h2>Sample SVG Assets</h2>
    <div class="inner">
    <?php
    $dir = '../common/svg/'; 
    $files = glob($dir . "*.svg");

    if ($files) {
        foreach ($files as $file) {
            $filename = basename($file);
    ?>
    <div class="svg" data-url="<?=$dir.$filename?>">
        <img src="<?=$file?>">
        <div><?=$filename?></div>
    </div>
     <?php
        }
    } else {
        echo "SVG file not found.";
    }
    ?>
    </div>
</div>

<div id="footer">
<div class="inner">
    <div id="copy">&copy; 2026 3Dvenue. All rights reserved.</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script type="text/javascript">
$(function(){

const allParts = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;

let sectiondom = `<section class="">
   <div class="inner">
   </div>
</section>`;

let elemntdom = `<div class="">
</div>`;

    $('#selectparts').on('change',function(){
        let id = $(this).val();
        $('section').removeClass();
        $('#'+id).addClass('active');
    })

    $('#selectparts').val($('option[data-cid="<?=$tid?>"]').val()).change();


    $('#new').on('click',function(e){
        let tid = $('section.active').data('tid');
        if(tid == "2"){
            $('#cid').val('');
            $('select[name="type"]').val(tid);
            $('#pname').val('');
            $('#psize').val('0');
            // websitemode
            $('#pageeditor').removeClass().addClass('active');
        }else{
            $('#cid').val('');
            $('select[name="type"]').val(tid);
            $('#cname').val('');
            $('#memo').val('');
            switch(tid){
                case 0:
                    $('#dom').val(sectiondom);
                    hvewset(tid,sectiondom);
                break;

                case 1:
                    $('#dom').val(elemntdom);
                    hvewset(tid,elemntdom);
                break;
    
                default:
                    alert('miss');
                break;
             }
            $('#editor').removeClass().addClass("active new");
        }
    })

    $('#type').on('change',function(){
        let option = $(this).val();
        switch(option){
            case "0":
                $('#dom').val(sectiondom);
                hvewset(option,sectiondom);
                break;
            case "1":
                $('#dom').val(elemntdom);           
                hvewset(option,elemntdom);
                break;
            default:
                break;
            }
    })

    $('#editor .close,#sampleurl .close').on('click',function(){
        $('#editor,#sampleurl').removeClass();
    })

    $('#dom').on('input change',function(){
        let tid = $('#type').val();
        let dom = $(this).val();
        hvewset(tid,dom);
        makeHFimage();
    })

    $('span.hadle').on('mousedown', function(e) {
        console.log('mousedows');
        e.preventDefault();
        let targetPopup = $(this).closest('#editor form');
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

    function hvewset(tid,dom){
        let vewhtml = "";
        tid = Number(tid);
        switch(tid){
            case 0:
                vewhtml = '<main>'+dom+'</main>'; 
            break;

            case 1:
                vewhtml = '<main>'+dom+'</main>';
            break;
        }
        $('#view').html(vewhtml);
        makeHFimage();
    }


    $('#elements div.parts,#sections div.parts').on('click', function(){
        const cid = $(this).data('cid');
        const tid = $('section.active').data('tid');
        const data = allParts.find(p => p.cid == cid);
            $('#cid').val(data.cid);
            $('select[name="type"]').val(data.type);
            $('#cname').val(data.cname);
            $('#memo').val(data.memo);
            $('#dom').val(data.dom);
            hvewset(tid,data.dom);
            // $('#view').html(data.dom);
            $('#editor').removeClass().addClass("active edit");
            makeHFimage();
    });

    $('section#pages div.parts').on('click', function(){
        const cid = $(this).data('cid');
        const data = allParts.find(p => p.cid == cid);
            $('#pcid').val(data.cid);
            $('#pname').val(data.cname);
            $('#body main').html(data.dom);
            $('#pageeditor').addClass("active edit");
            pdomset();
            makePageThum();
    });

    $('#pageeditor > .close').on('click',function(){
        $('#pageeditor').removeClass('active');
    })


    $('#pageesections div.parts').on('click', function(){
        const cid = $(this).attr('data-cid');
        const data = allParts.find(p => p.cid == cid);
            $('#siteimage #body main').append(data.dom);
            pdomset();
            makePageThum();
    });


    function pdomset(){
        $('#pdom').val($('#siteimage #body main').html());
    }

    $('#psize').on('input',function(){
       let size = $(this).val();
       let scale = size / 100;
       $('#body').css({'height':size+'%','transform':'scale(calc(100% / '+scale+'))'});
       console.log(size);
    })

    $('#reset').on('click',function(e){
        e.preventDefault();
        $('#psize').val('100');
        $('#psize').trigger('input');
    })


    $('#maxwidth').on('click',function(){
        $('#body').addClass('maxwidth');
    })

    $('#body .close').on('click',function(){
        $('#body').removeClass('maxwidth');
    })

    $(document).on('click','#body section',function(){
        $('#body section').removeClass('active');
        $(this).addClass('active');
    })

    $('#up').on('click', function() {
        var $active = $('main section.active');
        $active.insertBefore($active.prev('section'));
        makePageThum();
    });

    $('#down').on('click', function() {
        var $active = $('main section.active');
        $active.insertAfter($active.next('section'));
        makePageThum();
    });

    $('#trash').on('click', function() {
        $('main section.active').remove();
    });

    $('#clear').on('click', function() {
        $('main section.active').removeClass('active');
        $('#move').removeClass('active');
        pdomset();
        makePageThum();
    });

    $(document).on('keyup', function(e) {
        if (!$('main section.active').length) return;
        switch(e.which) {
            case 38: $('#up').trigger('click'); break;    // ↑キー
            case 40: $('#down').trigger('click'); break;  // ↓キー
            case 46: 
            case 8:  $('#trash').trigger('click'); break; // Delete / Backspace
            case 27: $('#clear').trigger('click'); break; // Esc
        }
    });

    function makePageThum(){
        const target = document.getElementById('body');
        
        const realW = target.scrollWidth;
        const realH = target.scrollHeight;

        const thumbW = 600; 
        const thumbH = (realH / realW) * thumbW; 

        domtoimage.toBlob(target, {
            width: realW, 
            height: realH,
            style: {
                'overflow': 'visible', 
                'height': realH + 'px' 
            }
        })
        .then(function (blob) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = thumbW;  
                canvas.height = thumbH; 
                const ctx = canvas.getContext('2d');
                
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                
                ctx.drawImage(img, 0, 0, thumbW, thumbH);

                const webpData = canvas.toDataURL('image/webp', 0.8);

                $('#pimage').val(webpData);

                $('#pagePreview').css({
                    'background-image': 'url(' + webpData + ')'
                });

                URL.revokeObjectURL(img.src);
            };
            img.src = URL.createObjectURL(blob);
        });
    }


    function makeHFimage(){
        var node = $('#view')[0];
        domtoimage.toPng(node)
        .then(function(dataUrl){
            $('#checkimage img').attr('src', dataUrl);
            $('#cimage').val(dataUrl);
        });

    }

    $('#sampleaccet').on('click',function(e){
        $('#sampleurl').addClass('active');
    });

    $('#sampleurl .inner .svg').on('click',function(){
        let copyurl = $(this).attr('data-url');
        if (copyurl) {
            navigator.clipboard.writeText(copyurl).then(() => {
                alert(copyurl + ' copied');
            });
           
        }
    });

    $('#dom').on('keydown', function(e) {
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

});
</script>
</body>
</html>