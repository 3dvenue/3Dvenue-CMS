<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit = $_POST['submit'] ?? '';
    $cid    = $_POST['cid'] ?? '';
    $type   = $_POST['type'] ?? '0';
    $cname  = $_POST['cname'];
    $dom    = $_POST['dom'];
    $memo   = $_POST['memo'];
    $publish  = $_POST['publish'] ?? '';
    $cimage = $_POST['cimage'] ?? ''; // JSから届くBase64データ

    $saveImage = function($id, $base64Data) {
        if (!$base64Data) return;
        $img = preg_replace('/^data:image\/png;base64,/', '', $base64Data);
        $img = str_replace(' ', '+', $img);
        $binary = base64_decode($img);
        $pngPath = "./parts/{$id}.png";
        file_put_contents($pngPath, $binary);
        $image = imagecreatefrompng($pngPath);
        $webpPath = "./parts/{$id}.webp";
        imagewebp($image, $webpPath, 80);
        imagedestroy($image);
        unlink($pngPath);
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

    if($publish == 'publish'){
        switch ($type) {
            case 3:
            file_put_contents('../common/inc/header.txt',$dom); 
                break;

            case 4:
            file_put_contents('../common/inc/footer.txt',$dom);  
                break;
 
            case 5:
            file_put_contents('../common/inc/aside-base.txt',$dom);  
                break;

            default:
                // code...
                break;
        }
    }

    // header('Location: ' . $_SERVER['PHP_SELF']); 
    // exit;
}

$sql = "SELECT * FROM contents WHERE type >= 3 ORDER BY cname";
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
    <link rel="stylesheet" type="text/css" href="./css/block.css?t=<?=time()?>">
</head>
<body>
<div id="main">
<div class="inner">
<h2><?=$lang['common_area'][$lng]?>
<span><?=$lang['common_area_memo'][$lng]?></span>
</h2>

<section id="headers" data-tid="3">
    <details>
    <span class="new">＋</span>
    <summary><h3>Header Parts</h3></summary>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '3'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>

    </details>
</section>

<section id="footers" data-tid="4">
    <details>
    <span class="new">＋</span>
    <summary><h3>Footer Parts</h3></summary>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '4'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>
    </details>
</section>

<section id="aside" data-tid="5">
    <details>
    <span class="new">＋</span>
    <summary><h3>Aside Parts</h3></summary>
    <div class="flex">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['type'] == '5'): ?>
                <div class="parts element" data-cid="<?= $row['cid'] ?>">
                    <div class="image">
                        <img src="./parts/<?= $row['cid'] ?>.webp?t=<?=time()?>">
                    </div>
                    <div class="name"><?= $row['cname'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
       </div>
    </details>
</section>


</div>
</div><!-- #main -->

<div id="editor">
    <div class="close">✕</div>
    <div id="form">
        <div id="checkimage"><img src=""></div>
        <div id="wrapper"><div id="view"></div></div>
        <form method="POST">
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
                            <option value="3">Header</option>
                            <option value="4">Footer</option>
                            <option value="5">aside-base</option>
                        </select><span>：Type</span>
                    </label>
                </div>
                <div><label><input type="text" id="cname" name="cname" /><span>：Name</span></label></div>
                <div class="memo"><label><input type="text" name="memo" id="memo" value=""><span>：MEMO</span></label></div>
                <div class="publish"><label><input type="checkbox" name="publish" id="publish" value="publish"><span>：公開</span></label></div>
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


<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script type="text/javascript">
$(function(){

const allParts = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;

let headerdom = `<div id="logo"><a href="/"><img src="../common/img/logo.webp" alt="logo"></a></div>`;

let footerdom = `<div id="copyright">&copy;3Dvenue</div>`;

let asidedom = `<div class="inner"></div>`;

    $('#editor .close').on('click',function(){
        $('#editor').removeClass();
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
            case 3:
                vewhtml = '<header><div class="inner">'+dom+'</div></hrader>';
            break;

            case 4:
                vewhtml = '<footer>'+dom+'</footer>';
            break;

            case 5:
                vewhtml = '<aside class="base"><div class="inner">'+dom+'</inner></aside>';
            break;

        }
        $('#view').html(vewhtml);
        makeHFimage();
    }


    $('div.parts').on('click', function(){
        const cid = $(this).data('cid');
        const tid = $(this).closest('section').data('tid');
        const data = allParts.find(p => p.cid == cid);
            $('#cid').val(data.cid);
            $('#dom').val(data.dom);
            $('select[name="type"]').val(data.type);
            $('#cname').val(data.cname);
            $('#memo').val(data.memo);
            hvewset(tid,data.dom);
            $('#editor').removeClass().addClass("active edit");
            makeHFimage();
    });


    $('section .new').on('click', function(){
        const cid = '';
        const tid = $(this).closest('section').data('tid');
            $('#cid').val(cid);
            $('#dom').val(cid);
            $('select[name="type"]').val(tid);
            $('#cname').val(cid);
            $('#memo').val(cid);
            hvewset(tid,cid);
            $('#editor').removeClass().addClass("active new");
            makeHFimage();
    });


    $('#reset').on('click',function(e){
        e.preventDefault();
        $('#psize').val('100');
        $('#psize').trigger('input');
    })

    function makeHFimage(){
        var node = $('#view')[0];
        domtoimage.toPng(node)
        .then(function(dataUrl){
            $('#checkimage img').attr('src', dataUrl);
            $('#cimage').val(dataUrl);
        });
    }

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