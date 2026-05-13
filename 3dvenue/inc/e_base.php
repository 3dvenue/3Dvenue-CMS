<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="layouteditor" class="baseMenu">
    <div class="inner">
        <div class="close">✕</div>
    <h3>Layout</h3>
    <div>

    </div>
    </div>
</div>

<div id="seoeditor" class="baseMenu">
    <div class="inner">
        <div class="close">✕</div>
    <h3>SEO (Search Engine Optimization)</h3>
    <div id="seoBox">

        <details>
            <summary><?=$lang['seo_sitename'][$lng]?> (meta-sitename)</summary>
            <p><?=$lang['seo_sitename_memo'][$lng]?></p>
        <input type="text" name="sitename" id="sitename" value="<?=$sitename?>" placeholder="このサイトのサービス名（共通）">
        <div class="submit"><div class="btn" data-name="sitename"><?=$lang['save'][$lng]?></div></div>
        </details>
        <details>
            <summary><?=$lang['seo_pagetitle'][$lng]?> (titile)</summary>
            <p><?=$lang['seo_pagetitle_memo'][$lng]?></p>
            <input type="text" name="title" id="pagetitle" value="<?=$title?>" />
        <div class="submit"><div class="btn" data-name="pagetitle"><?=$lang['save'][$lng]?></div></div>
        </details>

        <details>
            <summary><?=$lang['seo_description'][$lng]?> (meta-description)</summary>
            <p><?=$lang['seo_description_memo'][$lng]?></p>
        <textarea type="text" name="description"  id="description" ><?=$description?></textarea>
        <div class="submit"><div class="btn" data-name="description"><?=$lang['save'][$lng]?></div></div>
        </details>

        <details>
            <summary><?=$lang['seo_other'][$lng]?></summary>
            <p><?=$lang['seo_other_memo'][$lng]?></p>
        <textarea type="text" name="other"  id="other" ><?=$other?></textarea>
        <div class="submit"><div class="btn" data-name="other"><?=$lang['save'][$lng]?></div></div>
        </details>

        <details for="image" class="snsimage">
            <summary><?=$lang['seo_ogimage'][$lng]?> (og:image)</summary>
            <div id="snsview"><label for="snsimage"><?=$lang['select'][$lng]?></label></div>
            <p><?=$lang['seo_ogimage_memo'][$lng]?></p>
            <input type="file" name="snsimage" id="snsimage" value="">
        <div class="submit"><div class="btn" data-name="snsimage"><?=$lang['save'][$lng]?></div></div>
        </details>

        <details>
            <summary><?=$lang['seo_jsonld'][$lng]?> (Json-LD)</summary>
            <p><?=$lang['seo_jsonld_memo'][$lng]?></p>
        <textarea name="jsonld" id="jsonld"><?=$jsonld?></textarea>
        <div class="submit"><div class="btn" data-name="jsonld"><?=$lang['save'][$lng]?></div></div>
        </details>
        <?php $checked = ($robots >= 1) ? 'checked' : ''; ?>
        <details>
            <summary><?=$lang['seo_noindex'][$lng]?> (meta robots->noindex,nofollow)</summary>
            <p><?=$lang['seo_noindex_memo'][$lng]?></p>
            <div class="submit"><input type="checkbox" name="noindex" id="noidex" value="1" <?=$checked?>>
                <div class="btn" data-name="noidex"><?=$lang['setup'][$lng]?></div></div>
        </details>
    </div>
    </div>
</div>
