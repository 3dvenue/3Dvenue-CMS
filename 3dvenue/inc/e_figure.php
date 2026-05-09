<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="figureeditor">
    <div class="close btn">✕</div>
    <div class="inner">
        <div clas="top">
            <div class="tagname">figure img</div>
            <div class="section">
                <label>Class名<input type="tex" id="f-class" value=""></label>
            </div>
            <div class="section">
                <button class="btn" id="cleartstyle">スタイル削除</button>
            </div>

            <div>
                <label>link設定<input type="tex" id="imagelink" value=""></label>
                <button class="btn" id="imagelinkset">リンク設定</button>                
            </div>

        </div>
        <div clas="middle">
            <div class="section aspectsize">
                <div class="label">サイズ（比率）: </div>
                <div id="aspectbox">
                    <span class="aspect" data-aspect="16/9" title="動画サイズ">16:9</span>
                    <span class="aspect" data-aspect="3/2" title="35mmフィルム比">3:2</span>
                    <span class="aspect" data-aspect="1.618/1" title="黄金比">1.618:1</span>
                    <span class="aspect" data-aspect="1.414/1" title="白銀比/大和比">1.414:1</span>
                    <span class="aspect" data-aspect="1/1" title="スクエア">1:1</span>
                    <span class="aspect" data-aspect="4/5" title="SNSポートレート">4:5</span>
                    <span class="aspect" data-aspect="9/16" title="スマホ全画面">9:16</span>
                </div>
            </div><!-- section -->
        </div>

        <div clas="bottom">
            <div class="section image">
                
                <div id="imagesetup">
                    <div class="section">
                        <div>画像：</div>
                        <div id="selectimage" class="btn">背景画像を選択</div>
                        <div id="deleteimage" class="btn">削除</div>
                    </div>
                </div>

                <div id="imagealt">
                    <div class="section">
                        <div>画像の説明（altタグ）：</div>
                        <div><input type="text" name="alt" id="alt" value="" placeholder="画像の説明"></div>
                        <div id="altsetup" class="btn">設定</div>
                    </div>
                </div>

            </div><!-- section -->
        </div>
    </div> <!-- inner -->
</div>