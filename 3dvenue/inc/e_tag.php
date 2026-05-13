<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="tageditor">
    <div class="close btn">✕</div>
    <div class="inner">
        <div class="top">
            <div id="tagname"></div>
            <div class="section">
                <label>Class:<input type="tex" id="t-class" id="t-class" value=""></label>
            </div>
        </div>
        <div class="middle">
            <div class="section background">

                <div class="color">
                    <div class="label">Background Color:</div>
                    <label><input type="color" id="t-color" value="#FFFFFF">:Color1</label>
                    <label><input type="range" class="alpha" id="t-alpha" min="0" step="1" max="255" value="127">:Transparent</label>
                </div>
            </div><!-- section -->
        </div>

        <div class="bottom">
            <div class="section yohaku">

                <div class="padding">
                    <div class="label">Padding:</div>
                    <input type="number" class="padding" id="t-padding" min="0" max="50" value="0">
                </div>
                <div class="radius">
                    <div class="label">Radius:</div>
                    <input type="number" class="radius" id="t-radius" min="0" max="50" value="0">
                </div>

                <div class="border">
                    <div class="label">Border:</div>
                    <label><input type="number" id="t-border" min="0" max="359" step="1" value="0">:Line Size</label>
                    <label>
                        <select id="t-bstyle">
                            <option value="none">none</option>
                            <option value="solid">solid</option>
                            <option value="dashed">dashed</option>
                            <option value="dotted">dotted</option>
                            <option value="double">double</option>
                            <option value="groove">groove</option>
                            <option value="outset">outset</option>
                        </select>:Line Style
                    </label>
                    <label><input type="color" id="t-bcolor" value="#1a4a9e">:Color</label>
                </div>

            </div><!-- section -->
        </div>
	</div> <!-- inner -->
</div>