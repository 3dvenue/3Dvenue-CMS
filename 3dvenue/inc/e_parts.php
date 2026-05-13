<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) exit;
?>
<div id="parts">
	<div class="sectionClose">✕</div>

	<div id="sectionparts" class="select">
		<h2>Add Section</h2>
		<div id="addsection">
			<label><input type="radio" name="addsection" class="addsection" value="before" checked>:Before</label>
			<label><input type="radio" name="addsection" class="addsection" value="after">:After</label>
			<section>
			<?php foreach ($sections as $section): ?>
				<?php if ($section['type'] == '0'): ?>
				<div class="parts" data-cid="<?= $section['cid'] ?>">
					<div class="image"><img src="./parts/<?= $section['cid'] ?>.webp"></div>
					<div class="name"><?= $section['cname'] ?></div>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</section>
		</div>
	</div>

	<div id="contensparts" class="select">
		<h2>Add Parts</h2>
		<div id="addParts">
			<label><input type="radio" name="addparts" class="addparts" value="before" checked>:Before</label>
			<label><input type="radio" name="addparts" class="addparts" value="after">:After</label>
			<section>
			<?php foreach ($sections as $section): ?>
				<?php if ($section['type'] == '2'): ?>
				<div class="parts" data-cid="<?= $section['cid'] ?>">
					<div class="image"><img src="./parts/<?= $section['cid'] ?>.webp"></div>
					<div class="name"><?= $section['cname'] ?></div>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</section>
		</div>
	</div>

	<div id="pageparts" class="select">
		<h2>Add Page Sample</h2>
		<div id="addPage">
			<section>
			<?php foreach ($sections as $section): ?>
				<?php if ($section['type'] == '2'): ?>
				<div class="pages" data-cid="<?= $section['cid'] ?>">
					<div class="image"><img src="./parts/<?= $section['cid'] ?>.webp"></div>
					<div class="name"><?= $section['cname'] ?></div>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</section>
		</div>
	</div>


<div id="pageview">
	<div id="pageaddbutton">
	<div class="closeviw">✕</div>
		<form method="post">
			<input type="hidde" name="cid" id="tempid" value="">			
			<input type="text" name="pagename" id="pagename" value="" placeholder="Enter page name..." required>
			<button type="submit" name="submit" value="newpage">Add Page</button>
		</form>
	</div>
	<div class="view">
		<img src="">
	</div>
</div>

</div>
