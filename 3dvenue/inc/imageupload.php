<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="imageupload">
    <div class="close">✕</div>
    <div id="view"></div>
        <div id="form">
            <label><span class="btn">画像を選択</span>
            <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg, .webp"></label>
            <p><input type="text" name="imgname" id="imgname" value="" placeholder="画像名">.webp</p>
            <div id="btn">
            <button type="submit" id="submit" class="btn" name="submit" value="upload">画像をアップロードする</button>
            </div>
        </div>
    </div>
</div>

<div id="imagecrop">
    <div class="close">✕</div>
        <div class="wrap">
        <div id="cropview">
            <div id="cropper"></div>
       <img id="photo" src="https://ai.3dvenue.jp/common/svg/photo.svg">
        </div>
    </div>
        <div id="cropbox">
            <span class="aspect" data-aspect="16/9" title="動画サイズ">16:9</span>
            <span class="aspect" data-aspect="3/2" title="35mmフィルム比">3:2</span>
            <span class="aspect" data-aspect="1.618/1" title="黄金比">1.618:1</span>
            <span class="aspect" data-aspect="1.414/1" title="白銀比/大和比">1.414:1</span>
            <span class="aspect active" data-aspect="1/1" title="スクエア">1:1</span>
            <span class="aspect" data-aspect="4/5" title="SNSポートレート">4:5</span>
            <span class="aspect" data-aspect="9/16" title="スマホ全画面">9:16</span>
            <input type="range" id="croprange" name="croprange" min="-30" max="30" step="0.5" value="0"><label for="croprange">:回転</label>
        </div>
        <div id="inputbox">
            <input type="text" name="imgname" id="cropname" value="" placeholder="画像名">
            <button id="makeCrop" class="btn">画像を生成</button>
            <button type="submit" id="delete"  class="btn" name="submit" value="delete"><img src="./lib/trash.svg"></button>
        </div>
</div>

<form id="cropform" method="post" action="croptowaep.php">
<input type="hidden" id="cropdata" name="cropdata" value="">
<input type="hidden" id="cropdataname" name="cropname" value="">
</form>