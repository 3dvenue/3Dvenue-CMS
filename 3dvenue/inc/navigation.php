<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="navilists">
	<div id="nav0">
		<div class="navtitile active">
			<span>Global</span>
			<button id="nav0add" class="add">＋</button>
		</div>
		<div class="home" data-id="0" data-pid="1" data-link="" data-target="_self">
			<span class="name">HOME</span><span class="slug">/</span>
		</div>
		<ul id="navi0Box"></ul>
	</div>

	<div id="nav1">
		<div class="navtitile"><span>Sub</span>
			<button id="nav1add" class="add">＋</button>
			<button id="nav1-text-based"><span>ナビ操作</span></button>
		</div>
		<ul id="navi1Box"></ul>
<!-- 		<div id="navi1button">
		</div>
 -->	</div>
	<div id="nav2">
		<div class="navtitile"><span>Tertiary</span>
			<button id="nav2add" class="add">＋</button>
			<button id="nav2-text-based"><span>ナビ操作</span></button>
		</div>
		<ul id="navi2Box"></ul>
<!-- 		<div id="navi2button">
		</div>
 -->	</div>
</div>

<div id="navdock">
	<div id="navidata">
		<table>
			<tr><th>表示名</th><td><input type="text" name="name" id="name" value=""/></td></tr>
			<tr><th>構造</th><td><input type="text" name="slug" id="slug" value=""/></td></tr>
			<tr><th>内部リンク</th><td><select name="pid" id="pid">
				<?php foreach ($pages as $row) { ?>
					<option value="<?=$row['pid']?>"><?=$row['name']?></option>
				<?php } ?>
				<option value="0">外部リンク</option>
			</select></td></tr>
			<tr class="link"><th>外部リンク</th><td><input type="text" name="link" id="link" value="" placeholder="https://cms.3dvenue.jp" /></td></tr>
			<tr><th>表示先</th><td><select name="target" id="target"><option value="_self">同じ場所で</option><option value="_blank">_blank</option><option value="sub">新しいタブ内に表示</option></select></td></tr>
			<tr><th>保存</th><td><button id="makenavi">保存</button></td></tr>
		</table>

		<div id="checkbox">
			<div id="lr" class="move">
				<span id="left" title="左へ"><img src="./lib/left.svg"></span>
				<span id="right" title="右へ"><img src="./lib/right.svg"></span>
			</div>
			<div id="ud"  class="move">
				<span id="up" title="上へ"><img src="./lib/up.svg"></span>
				<span id="down" title="下へ"><img src="./lib/down.svg"></span>
			</div>
			<span id="deselect" title="選択解除">✕</span>
			<span id="delbtn" title="削除"><img src="./lib/trash.svg"></span>
		</div>

		<div id="submenu">
			<div id="subtitle">内部リンクを追加</div>
			<div id="submenus">
				<?php foreach ($pages as $row) { ?>
					<div class="menulist" data-pid="<?=$row['pid']?>"><?=$row['name']?></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>

<div id="savebtn">
	<div id="historybtn">
		<button id="navi_archive" class="btn">作業内容を新規保存</button>
		<button id="navi_upadate" class="btn">作業内容を上書き保存</button>
	</div>
	<div id="navimakebtn">
		<button id="make_html" class="btn">作業内容を上書き保存</button>
	</div>
</div>

<div id="navitext">
	<div id="closeNaviText">✕</div>
	<h3>ナビげションのテキスト編集</h3>
	<p>テキストをまとめて順序を入れ替えたい時に使用できます</p>
	<div class="naviTextArea">
		<textarea id="naviText"></textarea>
	</div>
	<div id="naviChangeBtn">
		<button id="changeNavi" class="btn">変更</button>
	</div>
</div>

