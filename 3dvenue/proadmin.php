<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
require_once('auth.php');
include_once('../common/inc/dbcall.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit = $_POST['submit'];
    
    if ($submit === 'add') {
        // 1. POSTデータを一括受け取り（村井さんのhidden一括送信！）
        $name        = $_POST['name'];
        $title       = $_POST['title'];
        $description = $_POST['description'];
        $main        = $_POST['main'];
        $css         = $_POST['css'];
        $js          = $_POST['js'];
        $public      = $_POST['public'] ?? '0';

            $sql = "INSERT INTO pages (name, title, description, main, css, js, public, sdate) 
                    VALUES (:name, :title, :description, :main, :css, :js, :public, DATETIME('now', 'localtime'))";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name'        => $name,
                ':title'       => $title,
                ':description' => $description,
                ':main'        => $main,
                ':css'         => $css,
                ':js'          => $js,
                ':public'      => $public
            ]);
        }

    if ($submit === 'edit') {
        $pid = $_POST['pid'];        
        $name = $_POST['name'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $main = $_POST['main'];
        $css = $_POST['css'];
        $js = $_POST['js'];
        $public = $_POST['public'] ?? '0';

        $sql = "UPDATE pages SET 
            name = :name, 
            title = :title, 
            description = :description, 
            main = :main, 
            css = :css, 
            js = :js, 
            public = :public 
            WHERE pid = :pid"; // これがないと全行更新されてしまうので注意！
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name'        => $name,
                ':title'       => $title,
                ':description' => $description,
                ':main'        => $main,
                ':css'         => $css,
                ':js'          => $js,
                ':public'      => $public,
                ':pid'      => $pid
            ]);
        }

            header('Location: ' . $_SERVER['PHP_SELF']); 
            exit;

}

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/proadmin.css">
    <style type="text/css">

    </style>
</head>
<body>
<div id="header">
<?php include_once('./inc/header.php')?>
</div>
<div id="nav">
<?php include_once('./inc/nav.php')?>
</div><!-- nav -->
<div id="main">
    <div class="inner">
        <h2>ページ情報の修正 <div class="btn" id="new">＋</div></h2>
        <section>
        <table>
            <tr>
                <th>name</th>
                <th>title</th>
                <th>description</th>
                <th>public</th>
            </tr>
                <?php
                $sql = "SELECT * FROM pages";
                $stmt = $conn->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $pid = $row['pid'];
                    $name = $row['name'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $public = $row['public'];
        ?>
            <tr data-pid="<?=$pid?>">
                <td><?=$name?></td>
                <td><?=$title?></td>
                <td><?=$description?></td>
                <td><?=$public?></td>
            </tr>
        <?php } ?>
        </table>
    </section>
    </div>
</div><!-- main -->
<div id="editor">
    <div id="form">
        <div class="close">✕</div>
        <form method="POST">
            <span>sdate：</span>
            <div id="input">
                <div id="up">
                    <input type="hidden" id="pid" name="pid" />
                    <label for="name" id="left"><span>Name：</span><input type="text" id="name" name="name" /></label>
                    <label for="title" id="right"><span>Title：</span><input type="text" id="title" name="title" /></label>
                </div>
                <label for="description"><span>Description：</span><input type="text" id="description" name="description" /></label>
            </div>
            <label><span>HTML</span><textarea name="main"></textarea></label>
            <label><span>CSS</span><textarea name="css"></textarea></label>
            <label><span>Javascript</span><textarea name="js"></textarea></label>
            <div id="submit">
                <label><span>公開：</span><input type="checkbox" name="public" value="1" /></label>
                <button type="submit" id="add" class="btn" name="submit" value="add">追加</button>
                <button type="submit" id="edit" id="" class="btn" name="submit" value="edit">保存</button>
                <button type="submit" id="dell" class="btn" name="submit" value="dell">削除</button>
            </div>
        </form>
    </div>
</div>
<div id="footer">
<?php include_once('./inc/footer.php')?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){

    $('#new').on('click',function(){
        $('#editor').removeClass().addClass("active new");
    })

    $('#editor .close').on('click',function(){
        $('#editor').removeClass();
    })

    // 一覧の行をクリックしたら編集モードへ
    $('table tr[data-pid]').on('click', function(){
        const pid = $(this).data('pid');
        console.log(pid);
        $.ajax({
            url: 'get_page_data.php',
            type: 'POST',
            data: { 'pid': pid },
            dataType: 'json'
        }).done(function(data){
            $('#pid').val(data.pid);
            $('#name').val(data.name);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('textarea[name="main"]').val(data.main);
            $('textarea[name="css"]').val(data.css);
            $('textarea[name="js"]').val(data.js);
            $('input[name="public"]').prop('checked', data.public == 1);
            $('#editor').removeClass().addClass("active edit");
            $('#editor').addClass('active');
        });
    });

});
</script>
</body>
</html>