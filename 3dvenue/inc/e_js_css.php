<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="js" class="bottompopup"><span class="hadle"></span>
    <h3>
        <p>Javascript</p>
        <p class="close">✕</p>
    </h3>
    <textarea class="codearea" name="jstextarea"><?=$css?></textarea>
    <div class="btn"><?=$lang['save'][$lng]?></div>
</div>

<div id="css" class="bottompopup"><span class="hadle"></span>
    <h3>
        <p>Style Sheet</p>
        <p class="close">✕</p>
    </h3>
    <textarea class="codearea" name="styletextarea"><?=$css?></textarea>
    <div class="btn"><?=$lang['save'][$lng]?></div>
</div>

<div id="html" class="bottompopup"><span class="hadle"></span>
    <h3>
        <p>HTML</p>
        <p class="close">✕</p>
    </h3>
    <textarea class="codearea" name="htmltextarea"></textarea>
    <div class="btn"><?=$lang['save'][$lng]?></div>
</div>
