<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="texteditor">
    <div class="close btn">✕</div>
    <div class="inner">

        <div class="section">
            <button id="clearSpan" class="btn">設定クリア</button>
        </div>

        <div class="section">
            <label for="f-family">フォントスタイル</label>
            <select id="f-family">
                <option value="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif">ゴシック</option>
                <option value="'Yu Mincho', 'Hiragino Mincho ProN', 'MS PMincho', serif">明朝</option>
                <option value="'SF Mono', 'Roboto Mono', 'Consolas', 'Menlo', monospace">等幅（Monospace）</option>
            </select>
        </div>

         <div class="section">
              <label for="f-color">カラー1:</label>
              <input type="color" id="f-color" value="#216AD2">
          </div>

        <div class="section">
            <label for="f-size">フォントサイズ</label>
            <input type="number" id="f-size" min="0.5" max="3" step="0.1" value="1">em
        </div>

        <div class="section">
            <label for="f-weight">太さ</label>
            <input type="number" id="f-weight" list="weights" min="100" max="900" step="100">
            <datalist id="weights">
              <option value="400">
              <option value="600">
              <option value="700">
            </datalist>
        </div>

        <div class="section selectText">
            <button id="editStart" class="btn">編集を開始</button>
            <button id="LinkStart" class="btn">リンク設定</button>
       </div>

        <div class="section LinkEditor">
            <button id="clearLink" class="btn">Linkクリア</button>

            <input type="text" id="link" name="link" placeholder="https://example.jp/">
            <button id="linkSet" class="btn">設定</button>
       </div>

	</div>
</div>


<div id="linkEditor">

</div>