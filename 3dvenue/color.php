<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit = $_POST['submit'];
    if ($submit === 'heart') {
        $cid = $_POST['cid'];
        $heart = $_POST['heart'];

        $sql = "UPDATE colors SET 
            heart = :heart
            WHERE colorid = :colorid"; // これがないと全行更新されてしまうので注意！            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':heart' => $heart,
                ':colorid' => $cid
            ]);
        exit('succsess');
    }
}

if(!empty($_POST['css'])){
    $css = $_POST['css'];
    $submit = $_POST['submit'];

    if ($submit === "saveAdmin") {
        file_put_contents('./common/css/color.css', $css);
    }

    if ($submit === "saveSite") {
        file_put_contents('./common/css/color.css', $css);
        file_put_contents('../common/css/color.css', $css);
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $submit = $_POST['submit'];
        $colorid       = $_POST['colorid'] ?? '0';
        $color1        = $_POST['color1'];
        $color2        = $_POST['color2'];
        $color3        = $_POST['color3'];
        $color4        = $_POST['color4'];
    
    if ($submit === 'add') {
            $sql = "INSERT INTO colors (color1, color2, color3, color4) 
                    VALUES (:color1, :color2, :color3, :color4)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':color1' => $color1,
                ':color2' => $color2,
                ':color3' => $color3,
                ':color4' => $color4
            ]);
        }

    if ($submit === 'update') {

        $sql = "UPDATE colors SET 
            color1 = :color1, 
            color2 = :color2, 
            color3 = :color3, 
            color4 = :color4 
            WHERE colorid = :colorid"; // これがないと全行更新されてしまうので注意！            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':color1' => $color1,
                ':color2' => $color2,
                ':color3' => $color3,
                ':color4' => $color4,
                ':colorid' => $colorid
            ]);
        }

header('Location: ' . $_SERVER['PHP_SELF']); 
exit;
}

$sql = "SELECT * FROM colors ORDER BY heart DESC";
$stmt = $conn->query($sql);
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" type="text/css" href="./css/colors.css?t=<?=time()?>">
</head>
<body>
<div id="header">
<?php include_once('./inc/header.php')?>
</div>
<div id="nav">
<?php include_once('./inc/nav.php')?>
</div><!-- nav -->
<div id="main">
<div class="inner">
    <h2>配色一覧<div id="new">＋</div></h2>
    <div id="heaercheck"><input type="checkbox" id="checkedheart" value="1"><label for="checkedheart"><span>❤</span></label></div>
    <div id="flex">
         <section id="colors">
        <ul>
        <?php foreach ($colors as $color): ?>
            <li class="parts element" data-cid="<?= $color['colorid'] ?>" data-heart="<?=$color['heart']?>">
                <div class="color1" style="background:<?= $color['color1'] ?>"><?= $color['color1'] ?></div>
                <div class="color2" style="background:<?= $color['color2'] ?>"><?= $color['color2'] ?></div>
                <div class="color3" style="background:<?= $color['color3'] ?>"><?= $color['color3'] ?></div>
                <div class="color4" style="background:<?= $color['color4'] ?>"><?= $color['color4'] ?></div>
                <label data-cid="<?= $color['colorid'] ?>">
                    <?php if($color['heart'] == '1'){$checked = "checked";}else{$checked = "";}; ?>
                    <input type="checkbox" class="heart" value="1" <?=$checked?>>
                    <span class="heart">♥</span>
                </label>
            </li>
        <?php endforeach; ?>
        </ul>
        </section>

        <section id="body">
            <header>
                <div class="inner">
                    <div id="logo"><img src="../common/img/logo.webp"></div>
                    <h1 style="color:#444444cc">3dvenue-CMS</h1>
                </div>
            </header>
            <nav>
                <div class="inner"><ul><li><a href="#">HOME</a></li><li><a href="#">Product</a></li><li><a href="#">Company</a></li><li><a href="#">Contact</a></li></ul></div>
            </nav>
            <main>
                <section class="eyecatch">
                    <div class="inner">
                    <h1>Color Mapping</h1>
                    </div>
                </section>
                <section class="block" style="padding:20px 0 0;">
                    <div class="inner" style="max-width:1040px;margin:0 auto;padding:0 20px">
                        <div class="content" style="display:grid;gap:clamp(5px , 5vw,10px);grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));">
                            <div class="card" style="width:100%;">
                                <figure>
                                </figure>
                                <p style="margin-top:0.5em;font-size:0.9em;">マウス操作だけで配色</p>
                            </div>
                            <div class="card" style="width:100%;">
                                <figure>
                                </figure>
                                <p style="margin-top:0.5em;font-size:0.9em;">何度でもやりなおせる</p>
                            </div>
                            <div class="card" style="width:100%;">
                                <figure>
                                </figure>
                                <p style="margin-top:0.5em;font-size:0.9em;">AIより自分の勘を信じて！</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="inner">
                    <h1>色と構造でつくる、壊れないデザイン</h1>
                    <h2>テーマカラーを変えても崩れないレイアウト設計</h2>
                    <h3>見出し・本文・ボタンの関係を最適化した配色ルール</h3>
                    <div class="text radius"><p>色が変わっても、<a href="#">デザインはそのまま美しく</a>ページ全体のバランスが崩れないように設計。誰が使っても扱いやすいデザインを目指しました。</p></div>
                    </div>
                </section>

                <section>
                    <div class="inner">
                    <div class="center"><a href="#" class="button1">普通のボタン</a></div>
                    <div class="center"><a href="#" class="button2">目立たせたいボタン</a></div>
                    </div>
                </section>
            </main>
            <footer>
                <div class="inner"><div>&copy;3dvenue present.</div></div>
            </footer>
        </section>
    </div><!-- flex -->

    <div id="mapping">
        <button id="startmapping" class="btn">カラーマッピングを開始</button>
        <div id="mapping_panel">
            <div class="close">✕</div>
            <div id="setcolor">
                <div class="colorbar c1"></div>
                <div class="colorbar c2"></div>
                <div class="colorbar c3"></div>
                <div class="colorbar c4"></div>
                <div id="paletchange">
                    <div id="up">▲</div>
                    <div id="down">▼</div>
                </div>
            </div>

            <label><input type="color" id="headercolor" class="headercolor" value="#FFFFFF"><span>Header</span>
                <input type="text" class="basecolor" value="#FFFFFF">
            </label>
            <label><input type="color" id="basecolor" class="basecolor" value="#FFFFFF"><span>Base</span>
                <input type="text" class="basecolor" value="#FFFFFF">
            </label>
            <label><input type="radio" class="makecolor" name="make" value="normal" checked><span>normal</span>
                <input type="radio" class="makecolor" name="make" value="tint"><span>Tint</span>
                <input type="radio" class="makecolor" name="make" value="shade"><span>Shade</span>
            </label>
            <label><input type="color" id="maincolor" class="maincolor" value="#007BFF"><span>Main</span>
                <input type="text" class="maincolor" value="#007BFF">
            </label>
            <label><input type="color" id="accentcolor" class="accentcolor" value="#FFC107"><span>Accent</span>
                <input type="text" class="accentcolor" value="#FFC107">
            </label>
            <label><input type="color" id="headercolor1" class="headercolor1" value="#333333"><span>H1/H2</span>
                <input type="text" class="headercolor1" value="#333333">
            </label>
            <label><input type="color" id="headercolor2" class="headercolor2" value="#333333"><span>H3/H4</span>
                <input type="text" class="headercolor2" value="#333333">
            </label>
            <label><input type="color" id="fontcolor" class="fontcolor" value="#333333"><span>Font</span>
                <input type="text" class="fontcolor" value="#333333">
            </label>
            <div id="saveBtn"><button class="btn" id="toAdmin" title="管理画面用に保存">決定</button><button class="btn" id="toSite" title="公開サイトに反映させる">公開</button>
        </div>
    </div><!-- mapping -->

    </div>
</div>


<div id="coloreditor">
    <div class="close">✕</div>
        <div id="form">
            <form method="post">
                <input type="hidden" id="colorid" name="colorid" value="">
                <label for="color1">カラー１：
                <input type="color" class="color1" value="#FFFFFF">
                <input type="text" id="color1" name="color1" value="#FFFFFF"> 
                </label>

                <label for="color2">カラー２：
                <input type="color" class="color2" value="#FFFFFF">
                <input type="text" type="" id="color2" name="color2" value="#FFFFFF"> 
                </label>

                <label for="color3">カラー３：
                <input type="color" class="color3" value="#FFFFFF">
                <input type="text" id="color3" name="color3" value="#FFFFFF"> 
                </label>

                <label for="color4">カラー４：
                <input type="color" class="color4" value="#FFFFFF">
                <input type="text"  id="color4" name="color4" value="#FFFFFF"> 
                </label>
                <div id="palettebtn">
                    <button type="submit" id="update" class="btn" name="submit" value="update">配色パレットを更新</button>
                    <button type="submit" id="add" class="btn" name="submit" value="add">配色パレットを追加</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>


<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script type="text/javascript">
$(function() {


    // cSS用変数の初期化
    let body_bg = "";
    let header_bg = "";
    let header_txt = "";
    let nav_bg = "";
    let nav_txt = "";
    let main_h1 = "";
    let main_h2 = "";
    let main_h3 = "";
    let main_h4 = "";
    let main_txt = "";
    let main_a_bg = "";
    let main_a_txt = "";
    let main_btn1_bg = "";
    let main_btn1_txt = "";
    let main_btn1_bord = "";
    let main_btn2_bg = "";
    let main_btn3_txt = "";
    let footer_bg = "";
    let footer_txt = "";

    // カウンターリセット
    let i = 0;
    // パレット初期化
    let palette = [];
    // 配色入替えパレット
    const patterns = [
        [0,1,2,3],[0,1,3,2],[0,2,1,3],[0,2,3,1],[0,3,1,2],[0,3,2,1],
        [1,0,2,3],[1,0,3,2],[1,2,0,3],[1,2,3,0],[1,3,0,2],[1,3,2,0],
        [2,0,1,3],[2,0,3,1],[2,1,0,3],[2,1,3,0],[2,3,0,1],[2,3,1,0],
        [3,0,1,2],[3,0,2,1],[3,1,0,2],[3,1,2,0],[3,2,0,1],[3,2,1,0]
    ];

    $('#new').on('click',function(){
        $('#coloreditor').removeClass().addClass('active');
        $('#color1,#color2,#color3,#color4,.color1,.color2,.color3,.color4').val('#FFFFFF');
    })

    $('.close').on('click',function(){
        $('#coloreditor').removeClass('active');
    })

    // 配色パレットの選択
    $('#colors li').on('click',function(){
        $('#colors li').removeClass('select');
        $(this).addClass('select');
        let mapcheck = $('#main').attr('class');
            let c1 = $(this).find('.color1').text();
            let c2 = $(this).find('.color2').text();
            let c3 = $(this).find('.color3').text();
            let c4 = $(this).find('.color4').text();
        // 一覧表示
        if(mapcheck !== 'mapping'){
            $('#color1,.color1').val(c1);
            $('#color2,.color2').val(c2);
            $('#color3,.color3').val(c3);
            $('#color4,.color4').val(c4);
            let cid = $(this).data('cid');
            $('#colorid').val(cid);
            $('#coloreditor').addClass('active update');
        }else{ //編集画面
            i = 0;
            palette = [c1, c2, c3, c4];
            paleteSet(i);
        }
    })


    function paleteSet(i){
        const p = patterns[i];
        let c1 = palette[p[0]];
        let c2 = palette[p[1]];
        let c3 = palette[p[2]];
        let c4 = palette[p[3]];
        $('.colorbar.c1').text(c1).css('background',c1);
        $('.colorbar.c2').text(c2).css('background',c2);
        $('.colorbar.c3').text(c3).css('background',c3);
        $('.colorbar.c4').text(c4).css('background',c4);
        $('.basecolor').val(c1);
        $('.maincolor').val(c2);
        $('.accentcolor').val(c4);
        colorSet();
    }

    // 色変更の動作
    $('.basecolor,.maincolor,.accentcolor,.headercolor1,.headercolor2,.fontcolor').on('input',function(){
        let classname = $(this).attr('class');
        let colorname = $(this).val();
        $('input.'+classname).val(colorname);
    })

    $('.makecolor').on('change',function(){
        colorSet();
    })

    // カラーセット関数
    function colorSet(){

       let makecolor = $('input.makecolor:checked').val();
       let basecolor = $('#basecolor').val();
       let base_check_color = basecolor;

       //ヘッダーフォントを決定
       $('.headercolor').val(colorChange(basecolor));

       if(makecolor !== 'normal'){
            percent = 95;
            base_check_color = colorChange(basecolor, percent, makecolor);
       }

       let fontcolor = textColor(base_check_color);
            $('input.headercolor1,input.headercolor2,input.fontcolor').val(fontcolor);


      let headerfont = colorChange(basecolor,70,'shade');

        // tintの時だけ、ヘッダーフォントを、見出しに適用
       if(makecolor == 'tint'){
            $('input.headercolor1').val(headerfont);
       }

        // shadeの時にBASE書き換え
       if(makecolor == 'shade'){
            percent = 50;
            base_check_color = colorChange(basecolor, percent, makecolor); 
        }
 
       let headercolor = $('#headercolor').val();
       let maincolor = $('#maincolor').val();
       let accentcolor = $('#accentcolor').val();
       let headercolor1 = $('#headercolor1').val();
       let headercolor2 = $('#headercolor2').val();

       // ナビゲーションとフッターはMainで設定
       $('section#body nav,section#body footer').css('background',maincolor);
       let navfooterfont = textColor(maincolor);

       //ノーマルボタンは、白1択で決定！
       $('a.button1').css('background','#FFFFFFee');
       $('a.button1').css('color','#333333');
       $('a.button1').css('border','1px solid #0000001D');


       let linkcolor = linkColor(base_check_color);

       // 条件
       $('section#body').css('background',base_check_color);
       $('section#body header').css('background',headercolor);
       $('#body a.button2').css('background',accentcolor);
       $('#body main h1:not(.eyecatch h1) ,#body main h2:not(.eyecatch h2) ').css('color',headercolor1);
       $('#body main h3').css('color',headercolor2);
       $('#body main .text,#body main .text *,#body main p,#body main span').css('color',headercolor2);
       $('#body main a:not(.button1)').css('color',linkcolor);
       $('#body header h1').css('color',headerfont);
       $('#body nav *,#body footer *').css('color',navfooterfont);

       //アクセントボタン背景
       let accentText = textColor(accentcolor);
       $('#body a.button2').css('color',accentText);
       let btnText = textColor(maincolor);

        body_bg = base_check_color;

        header_bg = headercolor;
        header_txt = headerfont;

        nav_bg = maincolor;
        nav_txt = navfooterfont;

        main_txt = headercolor2;
        main_h1 = headercolor1;
        main_h2 = headercolor1;
        main_h3 = headercolor2;
        main_h4 = headercolor2;
        main_a_txt = linkcolor;

        main_btn1_bg = '#FFFFFFee';
        main_btn1_txt = '#333333';
        main_btn1_bord = '#0000001D';

        main_btn2_bg = accentcolor;
        main_btn2_txt = accentText;

        footer_bg = maincolor;
        footer_txt = navfooterfont;

    }

    // ヘッダーカラー単独
    $('.headercolor').on('input',function(){
        let headercolor = $(this).val();
        headerfont = textColor(headercolor);
       $('section#body header').css('background',headercolor);
       $('#body header h1').css('color',headerfont);
    });

    // h1,h2カラー単独
    $('.headercolor1').on('input',function(){
        let headercolor1 = $(this).val();
       $('section#body main h1,section#body main h2').css('color',headercolor1);
    });

    // h3,h4カラー単独
    $('.headercolor2').on('input',function(){
        let headercolor2 = $(this).val();
       $('section#body main h3,section#body main h4').css('color',headercolor2);
    });

    // フォントカラー
    $('.fontcolor').on('input',function(){
        let fontcolor = $(this).val();
       $('section#body main .text,section#body main .text *').css('color',fontcolor);
    });

    $('#form input').on('input',function(){
        let forname = $(this).parent('label').attr('for');
        let color = $(this).val();
        $('input.'+forname+',input#'+forname).val(color);
    })

    //編集開始
    $('#startmapping').on('click',function(){
        $('body > #main').addClass('mapping');
        $('#colors .parts').eq(0).trigger('click');
        colorSet();
    })

    //編集終了
    $('#mapping_panel .close').on('click',function(){
        $('#colors li').removeClass('select');
        $('body > #main').removeClass('mapping');

    })

    function colorChange(hex, percent = 95, mode = "tint") {
        hex = hex.replace('#', '');

        let r = parseInt(hex.substring(0, 2), 16);
        let g = parseInt(hex.substring(2, 4), 16);
        let b = parseInt(hex.substring(4, 6), 16);

        let t = percent / 100;

        if (mode === "tint") {
            // 白(255) に寄せる
            r = Math.round(r + (255 - r) * t);
            g = Math.round(g + (255 - g) * t);
            b = Math.round(b + (255 - b) * t);
        } else {
            // 黒(0) に寄せる
            r = Math.round(r * (1 - t));
            g = Math.round(g * (1 - t));
            b = Math.round(b * (1 - t));
        }

        const toHex = (v) => v.toString(16).padStart(2, '0').toUpperCase();
        return '#' + toHex(r) + toHex(g) + toHex(b);
    }

    //明度計算機
    function brightness(hex){
        hex = hex.replace('#','');
        const r = parseInt(hex.substr(0,2),16);
        const g = parseInt(hex.substr(2,2),16);
        const b = parseInt(hex.substr(4,2),16);
        return (r * 299 + g * 587 + b * 114) / 1000;
    }

    //明度から色を計算。。。これは独自で書く
    function textColor(bg){
            const b = brightness(bg);
            if (b > 200) return "#333333";  // 明るい背景
            return "#FFFFFF";               // 暗い背景（#7c4529 はここ）
    }


    function linkColor(bg){
            const b = brightness(bg);
            if (b < 80) return "#2eA0ff";  //  暗い背景
            return "#0E11E9";  //色が薄ければ
    }

    // カラーパレットの切替
    $('#paletchange div').on('click', function(){
        let id = $(this).attr('id'); // 'up' or 'down'
        if(id === 'up'){
            i++;
        }else{
            i--;
        }
        if(i < 0) i = 23;
        let j = i % 24;
        paleteSet(j);
    });

    // 保存ボタン
    $('#saveBtn button').on('click',function(){
        let id = $(this).attr('id');

        const Stylesheet = `
        body{background:${body_bg};}

        header{background:${header_bg};}
        header h1{color:${header_txt};}

        nav,nav ul{background:${nav_bg};}
        nav a{color:${nav_txt};}

        main h1{color:${main_h1};}

        main h2{color:${main_h2};}

        main h3{color:${main_h3};}

        main h4{color:${main_h4};}

        main .text{color:${main_txt};}
        main p{color:${main_txt};}
        main span{color:${main_txt};}

        main a{color:${main_a_txt};}

        main a.button1{
            background:${main_btn1_bg};
            color:${main_btn1_txt};
            border:1px solid ${main_btn1_bord};
        }
        main a.button2{
        background:${main_btn2_bg};
        color:${main_btn2_txt};
        }

        footer{background:${footer_bg};}
        footer *{color:${footer_txt};}
        `;

        if(id == "toAdmin"){
            $.post('color.php', {
                css: Stylesheet,
                submit: "saveAdmin"
            }, function(res) {
                alert(id); 
                console.log(res);
            });
        }

        if(id == "toSite"){
            $.post('color.php', {
                css: Stylesheet,
                submit: "saveSite"
            }
            , function(res) {
                alert(id); 
                console.log(res);
            });
        }
        $('#colors li').removeClass('select');
        $('body > #main').removeClass('mapping');
    })


    $('#colors li label').on('click', function(e) {
        e.stopPropagation();
    })

    $('#colors li label input.heart').on('change', function(e) {
        let heart = $(this).prop('checked') ? 1 : 0;
        const cid = $(this).closest('li').data('cid');
        $(this).closest('li').attr('data-heart',heart);
        $.post('color.php',{
            cid:cid,
            heart:heart,
            submit:'heart'
            }, function(response){
            console.log("server response:", response);
            });
    })

    $('#checkedheart').on('change',function(){
      let checked = $(this).prop('checked');
      if(checked){
        $('#colors').addClass('heart');
      }else{
        $('#colors').removeClass('heart');
      }
    })

});
</script>
</body>
</html>