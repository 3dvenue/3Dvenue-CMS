<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="tageditor">
    <div class="close btn">✕</div>
    <div class="inner">
        <div clas="top">
            <div id="tagname"></div>
            <div class="section">
                <label>Class名<input type="tex" id="t-class" id="t-class" value=""></label>
            </div>
            <div class="section">
                <button class="btn" id="cleartstyle">スタイル削除</button>
            </div>
        </div>
        <div clas="middle">
            <div class="section background">

                <div>
                    <div class="label">背景: </div>
                    <label><input type="radio" class="mode" name="mode" value="solid" checked> 単色</label>
                    <label><input type="radio" class="mode" name="mode" value="grad"> グラデーション</label>
                </div>

                <div class="color">
                    <label><input type="color" id="t-color" value="#FFFFFF"> カラー1</label>
                    <label><input type="number" class="alpha" id="t-alpha1" min="0" max="127" value="127"> 透過</label>
                </div>

                <div class="gradient hidden">

                    <div class="color-row">
                        <label><input type="color" id="t-color2" value="#FFFFFF"> カラー2</label>
                        <label><input type="number" class="alpha" id="t-alpha2" min="0" max="127" value="127"> 透過</label>
                    </div>

                    <div class="angle">
                        <label><input type="number" id="t-angle" min="0" max="359" step="1" value="0">角度</label>
                    </div>

                </div><!-- gradient -->

            </div><!-- section -->
        </div>

        <div clas="bottm">
            <div class="section yohaku">

                <div class="padding">
                    <div class="label">余白</div>
                    <input type="number" class="padding" id="t-padding1" min="0" max="50" value="0">
                    <input type="number" class="padding" id="t-padding2" min="0" max="50" value="0">
                    <input type="number" class="padding" id="t-padding3" min="0" max="50" value="0">
                    <input type="number" class="padding" id="t-padding4" min="0" max="50" value="0">
                </div>

                <div class="radius">
                    <div class="label">角丸:</div>
                    <input type="number" class="radius" id="t-radius1" min="0" max="50" value="0">
                    <input type="number" class="radius" id="t-radius2" min="0" max="50" value="0">
                    <input type="number" class="radius" id="t-radius3" min="0" max="50" value="0">
                    <input type="number" class="radius" id="t-radius4" min="0" max="50" value="0">
                </div>

                <div class="border">
                    <div class="label">枠線:</div>
                    <label><input type="number" id="t-b-weight" min="0" max="359" step="1" value="0"> 太さ</label>
                    <label>
                        <select id="t-bstyle">
                            <option value="none">非表示</option>
                            <option value="solid">実戦</option>
                            <option value="dashed">破線</option>
                            <option value="dotted">点線</option>
                            <option value="double">二重線</option>
                            <option value="groove">凸</option>
                            <option value="outset">凹</option>
                        </select> 線種
                    </label>
                    <label><input type="color" id="t-bcolor" value="#1a4a9e"> 色</label>
                </div>

            </div><!-- section -->
        </div>
	</div> <!-- inner -->
</div>