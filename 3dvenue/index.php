<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
// root.txtの正確な記述を一回だけ実行するプログラム
$file = '../common/inc/root.txt';
if (file_exists($file)) {
    $roottext = file_get_contents($file);
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = str_replace(basename(__DIR__) . '/', '', $url);
    $url = str_replace('index.php', '', $url);
    if ($roottext !== $url) {
        file_put_contents($file, $url);
    }
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
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/index.css?t=<?=time()?>">
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
<h1>3Dvenue-CMS</h1>
<p class="memo">Google PageSpeed Insights 100点を目指せ！</p>

<a href="https://pagespeed.web.dev/analysis?url=<?=$url?>" target="insights" class="btn" id="toInsights">PageSpeed Insightsへ</a>

<section>
<h2>01. ノーコードでも編集可能な機能<span data-id="analog">詳細</span></h2>
<div id="analog" class="contents">

    <div class="content">
        <a href="editor.php"><figure>
            <img src="./lib/edit.svg">
        </figure></a>
        <div class="text">
            <h3>ページ編集</h3>
            <p>ヘッダーやフッターなどのテキストの編集をはじめ、コンテンツの文字の編集や配置、画像の設定などが出来るほか、ページ毎のSEOの編集が簡単にできるようになっています。<br/>
            javascriptやページ毎のスタイルシートを触ることも可能です</p>
        </div>
    </div>

    <div class="content">
        <a href="images.php"><figure>
            <img src="./lib/image.svg">
        </figure></a>
        <div class="text">
            <h3>画像一覧</h3>
            <p>画像だけを扱う領域です。追加した画像はすべてwebp形式に変換されます。アップロードできる画像の種類は、PNGとJPGになります。ここに配置した画像は、ページ編集から扱うことが出来ます</p>
        </div>
    </div>

    <div class="content">
        <a href="menu.php"><figure>
            <img src="./lib/navigation.svg">
        </figure></a>
        <div class="text">
            <h3>ナビゲーション編集</h3>
            <p>グローバルナビゲーションの設定と、第二階層目、第三階層目までのナビゲーション設定ができますが、第三階層目は、プルダウンでは出て来ない設定にしています。
            階層の深い情報を、作るのであれば、ディレクトリを別けて3Dvenueを配置し、移動先で専門性を持たせることが、SEOのためにも効果的です。</p>
        </div>
    </div>

    <div class="content">
        <a href="color.php"><figure>
            <img src="./lib/navigation.svg">
        </figure></a>
        <div class="text">
            <h3>ページカラー編集</h3>
            <p>１００種類の配色パレットから、今まで配色で頭を悩ませていた人は、この機能を使うことで、破綻しない形の配色を目で見て確認しながらマッピング出来ます。
            パレットはお気に入り♥マークをクリックしておけば、自分の好みの色だけで試すことができます。配色パレットは自分で新しく追加することも出来ます。</p>
        </div>
    </div>

</div>
</section>

<section>
<h2>02. HTMLやCSSの知識を必要とする編集機能<span data-id="technical">詳細</span></h2>
<div id="technical" class="contents">

    <div class="content">
        <a href="template.php"><figure>
            <img src="./lib/template.svg">
        </figure></a>
        <div class="text">
            <h3>テンプレート編集</h3>
            <p>テンプレートはサイト全体に共通するレイアウトを決定する要素になります。最初は４つのテンプレートを用意してありますが、あなたの専門的な知識やセンスで理想的なテンプレート編集や
            新しいテンプレートを開発することができます。CSSだけでは難しいレイアウトを作りたい時には、公開用のindex.phpの内容を手書きで書き換えることも出来ます。</p>
        </div>
    </div>

    <div class="content">
        <a href="parts.php"><figure>
            <img src="./lib/parts.svg">
        </figure></a>
        <div class="text">
            <h3>パーツ制作</h3>
            <p>最初は１０個のコンテンツパーツを提供しておりますが、もちろんこれで満足するあなたではないでしょう。専門的知識を活かしながら、お洒落なパーツを量産してください。3Dvenue用のオリジナル
            パーツを作りたい方は、こちらからどうぞ。パーツの販売など規制はございません。パーツを壊すことも出来てしまいますので、自己責任でお願いします。</p>
        </div>
    </div>

</div>
</section>

<!-- 
<section>
<h2>03. 保存されているデータの直接確認<span data-id="expert">詳細</span></h2>
<div id="expert" class="contents">

    <div class="content">
        <a href="proadmin.php"><figure>
            <img src="./lib/database.svg">
        </figure></a>
        <div class="text">
            <h3>SQLiteのデータ確認</h3>
            <p>SQLiteに保存されているデータがどのような構造になっているのかをご確認いだけます。直接の編集も出来ますが、かなり知識がある人でないと扱は少々危険かもしれません。</p>
        </div>
    </div>
</div>
</section>
 -->
<section id="rootcheck">
    <details>
        <summary>root.txtの設定確認</summary>
        <div><?=$url?></div>
        <p>※3dvenueではhttpsでのご利用を推薦しています。</p>
    </details>
</section>

</div>
</div><!-- main -->
<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){

        $('#pages li').on('click',function(){
            let pid = $(this).data('pid');
            $('#editor iframe').attr('src','editor.php?pid='+pid);
        })

        $('#editor .close').on('click',function(){
            $('#editor').removeClass();
        })

        $('#main section h2 span').on('click',function(){
            console.log('open');
          let id = $(this).data('id');
          $('div#'+id).toggleClass('open');
        })

    });
</script>
</body>
</html>