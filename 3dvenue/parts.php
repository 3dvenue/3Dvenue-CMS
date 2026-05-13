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

$sql = "SELECT * FROM contents ORDER BY cname";
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
    <link rel="stylesheet" type="text/css" href="./css/parts.css?t=<?=time()?>">
</head>
<body>
<div id="main">
<div class="inner">
<h2><span><?=$lang['parts_edit'][$lng]?></span>

<select id="selectparts">
    <option data-cid="0" value="sections">Section Parts</option>
    <option data-cid="1" value="elements">Element Parts</option>
    <option data-cid="2" value="pages">Web Pagedesign</option>
    <option data-cid="3" value="headers">Header Parts</option>
    <option data-cid="4" value="footers">Footer Parts</option>
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

<section id="headers" data-tid="3">
    <h3>Header Parts（※次期バージョンで対応予定）</h3>
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
</section>

<section id="footers" data-tid="4">
    <h3>footer Parts（※次期バージョンで対応予定）</h3>
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
                            <option value="3">Header</option>
                            <option value="4">Footer</option>
                        </select><span>：Type</span>
                    </label>
                </div>
                <div><label><input type="text" id="cname" name="cname" /><span>：Name</span></label></div>
                <div><label><input type="text" name="memo" id="memo" value=""><span>：MEMO</span></label></div>
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
<?php include_once('./inc/footer.php')?>
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

let headerdom = `<div id="headertext">HEADER TEXT</div>`;

let footerdom = `<div id="copyright">&copy;3Dvenue</div>`;

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

                case 3:
                    $('#dom').val(headerdom); 
                    hvewset(tid,headerdom);
                break;

                case 4:
                    $('#dom').val(footerdom);           
                    hvewset(tid,footerdom);
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
            case "3":
                $('#dom').val(headerdom);
                hvewset(option,headerdom);
                break;
            case "4":
                $('#dom').val(footerdom);           
                hvewset(option,footerdom);
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

            case 3:
                vewhtml = '<header><div class="inner"><div id="logo"><img src="../common/img/logo.webp"></div>'+dom+'</div></div>';
            break;

            case 4:
                vewhtml = '<footer>'+dom+'</footer>';
            break;
        }
        $('#view').html(vewhtml);
        makeHFimage();
    }


    $('#elements div.parts,#sections div.parts,#headers div.parts,#footers div.parts').on('click', function(){
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