<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?><div id="editor">
    <div class="inner">

        <div id="tools">
            <div id="home"><a href="index.php">🔙</a></div>
            <div id="scriptBtn">Script</div>
            <div id="styleBtn">Styles</div>
        </div>

        <div id="pagechange">
            <select id="selectPage">
            <?php foreach ($pages as $row) { ?>
                <option value="<?=$row['pid']?>"><?=$row['name']?></option>
            <?php } ?>
            </select>

            <div id="changenamebox"><input type="text" id="changepagename" value=""><button id="changename" class="btn">変更</button></div>

            <span id="newpage"><img src="./lib/newpage.svg" alt="newpage" title="新規ページ"></span>
            <span id="view"><img src="./lib/desktop.svg" alt="newpage" title="view"></span>
            <select id="bodysize">
                <option value="1.0">100%</option>
                <option value="0.9">90%</option>
                <option value="0.8">80%</option>
                <option value="0.7">70%</option>
                <option value="0.6">60%</option>
                <option value="0.5">50%</option>
                <option value="0.4">40%</option>
                <option value="0.3">30%</option>
                <option value="0.2">20%</option>
                <option value="0.1">10%</option>
            </select>
        </div>

        <span id="setting"><img src="./lib/settings.svg" alt="setting" title="設定"></span>
    </div>

    <div class="base">
        <div class="inner">
            <div data-id="seoeditor">SEO</div>
        </div>
    </div>
    </div>
</div>