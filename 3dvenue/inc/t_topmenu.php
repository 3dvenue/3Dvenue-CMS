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
                <!-- <span data-name="borderradius">BoredrRadius</span> -->
                <!-- <span data-name="spacing">Spacing</span> -->
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
            <div>
                <label><input type="radio" class="smode" name="smode" value="solid" checked> 単色</label>
                <label><input type="radio" class="smode" name="smode" value="grad"> グラデーション</label>
            </div>

            <div class="color-row">
                <label for="c1">カラー1:</label>
                <input type="color" id="c1" value="#ffcc00">
            </div>

            <div class="color-row" id="c2row">
                <label for="c2">カラー2:</label>
                <input type="color" id="c2" value="#ff6600">
            </div>

            <div id="angleRow">
                <label for="angle">角度:</label>
                <select id="angle">
                    <option value="to bottom">縦（上→下）</option>
                    <option value="to right">横（左→右）</option>
                    <option value="45deg">斜め ↗（45°）</option>
                    <option value="135deg">斜め ↘（135°）</option>
                </select>
            </div>
        </div>

        <div id="background">
            <div class="section">
                <div>背景画像</div>
                <div id="imageselect" class="btn">背景画像を選択</div>
                <div id="bgPreview" class="preview"></div>
                <div id="bgDelete" class="btn">削除</div>
            </div>
        </div>

        <div id="borderradius">
            <div class="radius-panel">
                <div class="row">
                    <label for="radius">角丸:</label>
                    <input type="range" id="radius" min="0" max="100" value="10">
                    <input type="number" id="radiusNum" min="0" max="100" value="10" style="width:60px;">
                    <span>px</span>
                </div>
            </div>
        </div>

        <div id="spacing">
          <h4>Margin</h4>
          <div class="mp-row">
            <label>上:<input type="number" id="mTop" value="0"></label>
            <label>右:<input type="number" id="mRight" value="0"></label>
            <label>下:<input type="number" id="mBottom" value="0"></label>
            <label>左:<input type="number" id="mLeft" value="0"></label>
          </div>

          <h4>Padding</h4>
          <div class="mp-row">
            <label>上:<input type="number" id="pTop" value="0"></label>
            <label>右:<input type="number" id="pRight" value="0"></label>
            <label>下:<input type="number" id="pBottom" value="0"></label>
            <label>左:<input type="number" id="pLeft" value="0"></label>
          </div>
        </div>

        <div id="section">
            <div class="section">
                <button id="addSection" class="btn">Sectionを挿入</button>
            </div>
            <div class="section">
                <button id="delSection"class="btn">このSecionを削除</button>
            </div>
        </div>

        <div id="sectionhtml">
            <div class="html">
                <button id="editHTML" class="btn">HTMLの編集を開始する</button>
            </div>
        </div>
    </div>

    <div id="movesection">
    Ctrl + ↑↓ 順序変更 / Reorder
    </div>


</div>