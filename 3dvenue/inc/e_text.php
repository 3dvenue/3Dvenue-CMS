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
            <label><select id="f-family">
                <option value="sans-serif;">Sans-Selif(Gothic)</option>
                <option value="serif">Serif(Mincho)</option>
                <option value="monospace">Monospace</option>
            </select>:Font Style</label>
        </div>

         <div class="section">
              <label><input type="color" id="f-color" value="#216AD2">:Color</label>
          </div>

        <div class="section">
            <label><input type="range" id="f-size" min="10" max="90" step="1" value="16">:Size</label>
        </div>

        <div class="section">
            <label><input type="checkbox" id="f-weight" value="bold">:Bold</label>
        </div>

        <div class="section selectText">
            <button id="editStart" class="btn">Edit Start</button>
            <button id="LinkStart" class="btn">Link Setup</button>
       </div>

        <div class="section LinkEditor">
            <button id="clearLink" class="btn">Clear</button>

            <input type="text" id="link" name="link" placeholder="https://example.jp/">
            <button id="linkSet" class="btn">Set</button>
       </div>

	</div>
</div>


<div id="linkEditor">

</div>