<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="topeditor">
    <div id="editmenu">
        <div class="inner">
            <div id="selectmenu">
                <span data-name="bgcolor">Color</span>
                <span data-name="background">Image</span>
                <span data-name="section">Section</span>
                <span data-name="sectionhtml">HTML</span>
                <div id="underbar"></div>
            </div>
            <div id="naming"><div id="tag"></div> id:<input type="text" id="idname"> class:<input type="text" id="classname"></div>
            <span class="close">✕</span>
        </div>
    </div>

    <div class="inner">
        <div id="bgcolor">
            <div class="color-row">
                <label for="c1">Color:</label>
                <input type="color" id="c1" value="#FFFFFF">
                <div id="colorreset" class="btn">削除</div>
            </div>
        </div>
        <div id="background">
            <div class="section">
                <div id="imageselect" class="btn"><?=$lang['select'][$lng]?></div>
                <div id="bgPreview" class="preview"></div>
                <div id="bgDelete" class="btn"><?=$lang['del'][$lng]?></div>
            </div>
        </div>

        <div id="borderradius">
            <div class="radius-panel">
                <div class="row">
                    <label for="radius">Radius:</label>
                    <input type="range" id="radius" min="0" max="100" value="10">
                    <input type="number" id="radiusNum" min="0" max="100" value="10" style="width:60px;">
                    <span>px</span>
                </div>
            </div>
        </div>

        <div id="spacing">
          <h4>Margin</h4>
          <div class="mp-row">
            <label><input type="number" id="mTop" value="0"></label>
<!--             <label>右:<input type="number" id="mRight" value="0"></label>
            <label>下:<input type="number" id="mBottom" value="0"></label>
            <label>左:<input type="number" id="mLeft" value="0"></label>
 -->          </div>

          <h4>Padding</h4>
          <div class="mp-row">
            <label><input type="number" id="pTop" value="0"></label>
<!--             <label>右:<input type="number" id="pRight" value="0"></label>
            <label>下:<input type="number" id="pBottom" value="0"></label>
            <label>左:<input type="number" id="pLeft" value="0"></label>
 -->          </div>
        </div>

        <div id="section">
            <div class="section">
                <button id="addSection" class="btn"><?=$lang['section_add'][$lng]?></button>
            </div>
            <div class="section">
                <button id="delSection"class="btn"><?=$lang['section_del'][$lng]?></button>
            </div>
        </div>

        <div id="sectionhtml">
            <div class="html">
                <button id="editHTML" class="btn"><?=$lang['html_edit'][$lng]?></button>
            </div>
        </div>
    </div>

    <div id="movesection">
    Ctrl + ↑↓ <?=$lang['reorder'][$lng]?>
    </div>


</div>