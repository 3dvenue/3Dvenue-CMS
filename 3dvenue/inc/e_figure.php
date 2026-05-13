<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="figureeditor">
    <div class="close btn">✕</div>
    <div class="inner">
        <div class="top">
            <div class="tagname">figure img</div>
            <div class="section">
                <label>Class<input type="tex" id="f-class" value=""></label>
            </div>

            <div>
                <label>URL:<input type="tex" id="imagelink" value=""></label>
                <button class="btn" id="imagelinkset"><?=$lang['setup'][$lng]?></button>                
            </div>

        </div>
        <div class="middle">
            <div class="section aspectsize">
                <div class="label">Aspect Ratio:</div>
                <div id="aspectbox">
                    <span class="aspect" data-aspect="16/9" title="Video">16:9</span>
                    <span class="aspect" data-aspect="3/2" title="35mm">3:2</span>
                    <span class="aspect" data-aspect="1.618/1" title="Golden">1.618:1</span>
                    <span class="aspect" data-aspect="1.414/1" title="Silver">1.414:1</span>
                    <span class="aspect" data-aspect="1/1" title="Square">1:1</span>
                    <span class="aspect" data-aspect="4/5" title="Portrait">4:5</span>
                    <span class="aspect" data-aspect="9/16" title="Mobile Fullscreen">9:16</span>
                </div>
            </div><!-- section -->
        </div>

        <div class="bottom">
            <div class="section image">
                
                <div id="imagesetup">
                    <div class="section">
                        <div id="selectimage" class="btn"><?=$lang['select'][$lng]?></div>
                    </div>
                </div>

                <div id="imagealt">
                    <div class="section">
                        <div>ALT:</div>
                        <div><input type="text" name="alt" id="alt" value=""></div>
                        <div id="altsetup" class="btn"><?=$lang['setup'][$lng]?></div>
                    </div>
                </div>

            </div><!-- section -->
        </div>
    </div> <!-- inner -->
</div>