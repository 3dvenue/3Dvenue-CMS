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
    <h3>SEO（検索エンジン対策）</h3>
    <div id="seoBox">

        <details>
            <summary>共通サイト名（meta-sitename）</summary>
            <p>※共通で表示される名前（会社名,サービス、ブランド名、大学名など）</p>
        <input type="text" name="sitename" id="sitename" value="<?=$sitename?>" placeholder="このサイトのサービス名（共通）">
        <div class="submit"><div class="btn" data-name="sitename">サイト名を保存</div></div>
        </details>
        <details>
            <summary>ページタイトル(titile)</summary>
            <p>※日本語30文字以内が良い</p>
            <input type="text" name="title" id="pagetitle" value="<?=$title?>" />
        <div class="submit"><div class="btn" data-name="pagetitle">タイトルを保存</div></div>
        </details>

        <details>
            <summary>ページ概要（meta-description）</summary>
            <p>※日本語では70〜120 文字が理想的</p>
        <textarea type="text" name="description"  id="description" ><?=$description?></textarea>
        <div class="submit"><div class="btn" data-name="description">ページ概要を保存</div></div>
        </details>

        <details>
            <summary>Speed Insightの検出からの対応策</summary>
            <p>listタグやmetaタグなどの補正が必要な時にheader内に書けるタグ類など</p>
        <textarea type="text" name="other"  id="other" ><?=$other?></textarea>
        <div class="submit"><div class="btn" data-name="other">other要素の保存</div></div>
        </details>

        <details for="image" class="snsimage">
            <summary>SNS用画像（og:image）</summary>
            <div id="snsview"><label for="snsimage">画像を選択</label></div>
            <p>※1200×600を推薦</p>
            <input type="file" name="snsimage" id="snsimage" value="">
        <div class="submit"><div class="btn" data-name="snsimage">SNS用画像のアップロード</div></div>
        </details>

        <details>
            <summary>構造化データ（Json-LD）</summary>
            <p>※必要なページは限られています。</p>
        <textarea name="jsonld" id="jsonld"><?=$jsonld?></textarea>
        <div class="submit"><div class="btn" data-name="jsonld">構造化データのアップロード</div></div>
        </details>
        <?php $checked = ($robots >= 1) ? 'checked' : ''; ?>
        <details>
            <summary>ノーインデクス（mata robots->noindex,nofollow）</summary>
            <p>※グーグルなどの検索エンジンに拾われたくないページに設定</p>
            <div class="submit"><input type="checkbox" name="noindex" id="noidex" value="1" <?=$checked?>>
                <div class="btn" data-name="noidex">ノーインデクス設定</div></div>
        </details>
    </div>
    </div>
</div>
