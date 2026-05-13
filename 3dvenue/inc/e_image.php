<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="imageeditor">
    <div class="close btn">✕</div>
    <div class="inner">
        <div class="section">
            <div>Background Image</div>
            <div id="imgelect" class="btn">File Select</div>
            <div id="imgPreview" class="preview"></div>
            <div id="imgDelete" class="btn"><?=$lang['del'][$lng]?></div>
        </div>
    </div><!--inner-->
</div><!--imageeditor-->



<div id="images">
    <div class="closeimage">✕</div>
     <section class="images">
        <h2>Select Image <div id="new">＋</div></h2>
            <?php
                $directory = '../common/img/';
                $files = glob($directory . "*.webp");
                $fileurl = $root.'common/img/';
            ?>
        <ul>
        <?php
            foreach ($files as $file) {
            $filename = explode('.',basename($file))[0];
        ?>
        <li data-url="<?=$directory.basename($file)?>" data-name="<?=$filename?>">
            <figure>
                <img src="<?=$directory.basename($file)?>?t=<?=time()?>">
                <figcaption><?=basename($file)?></figcaption>
            </figure>
        </li>
        <?php } ?>
        </ul>
    </section>
</div>

