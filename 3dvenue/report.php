<?php
include_once 'auth.php';
$root = file_get_contents('../common/inc/root.txt');
$log_file = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $search = $_POST['search'] ?? '';
    }else{
        $search = date("Y-m").'.txt';
    }

    $parts = explode('.', $search);
    list($year, $month) = explode('-', $parts[0]);

    $log_directory = "../common/log/";
    $files = glob($log_directory . '*.txt'); // ディレクトリ内の全てのファイルを取得

    $file_names = []; // ファイル名を格納する配列

    foreach ($files as $file) {
       $file_names[] = basename($file); // ファイル名を配列に追加
    }

    if(!empty($search)){
        $log_file =  $log_directory . $search;
    }

$file_exists = "";

if (empty($log_file)) {
    $log_file = $file;
}


if (file_exists($log_file)) {
    $logs = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    $logs = []; // ファイルが存在しない場合は空の配列にする
    $file_exists = "nofile";
}

//ログファイルを取得
if (file_exists($log_file)) {
    $log_contents = file_get_contents($log_file);
    $total_accesses = substr_count($log_contents, "\n");
} else {
    $log_contents = ''; // ファイルが存在しない場合は空にする
    $total_accesses = 0; // アクセス数をゼロにする
}

    // 各解析結果を格納する配列
    $daily_accesses = [];                       // 日別アクセス
    $hourly_accesses = [];                      // 時間別アクセス
    $page_accesses = [];                        // ページ別アクセス
    $ip_accesses = [];                     // 企業別アクセス

    foreach ($logs as $log) {
        $log_parts = explode(',', $log);  // ログデータをカンマ区切りで分割

        // 日付（1つ目のカラム）とその日付、時間部分の取得
        $date_time = trim($log_parts[0]);
        $date = substr($date_time, 0, 10);   // YYYY-MM-DD形式
        $hour = substr($date_time, 11, 2);   // HH形式

        // 日別アクセスのカウント
        if (!isset($daily_accesses[$date])) {
            $daily_accesses[$date] = 0;
        }

        $daily_accesses[$date]++;

        // 時間別アクセスのカウント
        if (!isset($hourly_accesses[$hour])) {
            $hourly_accesses[$hour] = 0;
        }
        $hourly_accesses[$hour]++;

        // ページ別アクセスのカウント（2つ目のカラム）
        $page = trim($log_parts[1]);
        if (!isset($page_accesses[$page])) {
            $page_accesses[$page] = 0;
        }

        $page_accesses[$page]++;

        // IPアドレス毎のカウントを取得
        $ip_id = trim($log_parts[2]);
        if (!isset($ip_accesses[$ip_id])) {
            $ip_accesses[$ip_id] = 0;
        }
        $ip_accesses[$ip_id]++;


    // 結果の配列を分割して使いやすくする
    $dates = array_keys($daily_accesses);
    $daily_access_counts = array_values($daily_accesses);
    $hours = array_keys($hourly_accesses);
    $hourly_access_counts = array_values($hourly_accesses);


    }

include_once('./lang.php');

?>
<!DOCTYPE html>
<html lang="<?=$lng?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="/favicon.ico">
    <title>3DVenue: Open Source CMS (MIT Licensed)</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/report.css?t=<?=time()?>">
</head>
<body>
<div id="main">
<div class="inner">
<section>
    <h1><?=$lang['access'][$lng]?></h1>
    <section class="pagetop">
    <div id="panel">
        <div id="search" class="card">
            <form method="post">
              <select name="search">
                <?php
                foreach (array_reverse($file_names) as $file_name) {
                    $selected = '';
                    $display_name = basename($file_name, '.txt');
                    if($search == $file_name){$selected = 'selected';}
                    echo "<option value=\"$file_name\" $selected>" . htmlspecialchars($display_name) . "</option>";
                }
                ?>
              </select>
              <button><?=$lang['update'][$lng]?></button>
            </form>
        </div>
    </div>
    </section>
<!-- </section>

<section id="reports"> -->
    <section class="daily-access">
        <details>
        <summary>
            <figure><img src="./lib/b-chart.svg"></figure>
            <h2><?=$lang['daily_access'][$lng]?><p><?=$lang['daily_access_memo'][$lng]?></p></h2>
            <span><?=array_sum($daily_accesses)?>hits</span>            
        </summary>
          <div id="daycheck" class="card">
            <table class="graf_table">
                <tr><th>date</th><th>count</th><th>graf</th></tr>
              <?php
                $max = max($daily_accesses);
                $base = max(50, $max);
                arsort($daily_accesses);
                foreach ($daily_accesses as $date => $count){
               $width = ($count / $base) * 100;
                ?>
                <tr>
                <td class="key"><?= $date ?></td>
                <td class="count"><?= $count ?></td>
                <td class="graf"><span style="width:<?=$width?>%;"></span></td>
                </tr>
              <?php } ?>
            </table>
        </div>
        </details>
      </section>

      <section class="time-access">
        <details>
        <summary>
            <figure><img src="./lib/b-time.svg"></figure>
            <h2><?=$lang['time-access'][$lng]?><p><?=$lang['time-access_memo'][$lng]?></p></h2>
            <span>24h</span>            
        </summary>
          <div id="hourcheck" class="card">
            <table class="graf_table">
            <tr><th>hour</th><th>count</th><th>graf</th></tr>
            <?php
            $max = max($hourly_accesses);
            $base = max(50, $max);
            $all_hours = array_fill(0, 24, 0);
            foreach ($hourly_accesses as $hour => $count) {
                $all_hours[$hour] = $count;
            }
            foreach ($all_hours as $hour => $count){
           $width = ($count / $base) * 100;
            ?>
            <tr>
                <td class="key"><?= $hour ?></td>
                <td class="count"><?= $count ?></td>
                <td class="graf"><span style="width:<?=$width?>%;"></span></td>
            </tr>
            <?php } ?>
            </table>
        </div>
      </details>
      </section>

      <section class="page-access">
        <details>
        <summary>
            <figure><img src="./lib/b-page.svg"></figure>
            <h2><?=$lang['page-access'][$lng]?><p><?=$lang['page-access_memo'][$lng]?></p></h2>
            <span><?=count($page_accesses)?>p</span>
        </summary>
          <div id="pagecheck" class="card">
            <table class="graf_table">
            <tr><th>slug</th><th>count</th><th>graf</th></tr>
            <?php
            $max = max($page_accesses);
            $base = max(50, $max);
            arsort($page_accesses);
            foreach ($page_accesses as $page => $count){
            $width = ($count / $base) * 100;
            ?>
            <tr>
                <td class="key"><?= $page ?></td>
                <td class="count"><?= $count ?></td>
                <td class="graf"><span style="width:<?=$width?>%;"></span></td>
            </tr>
          <?php } ?>
          </table>
        </div>
    </details>
      </section>

      <section class="ip-access">
        <details>
        <summary>
            <figure><img src="./lib/b-world.svg"></figure>
            <h2><?=$lang['ip-access'][$lng]?><p><?=$lang['ip-access_memo'][$lng]?></p></h2>
            <span><?=count($ip_accesses)?>hosts</span>
        </summary>
          <div id="ipcheck" class="card">
            <table class="graf_table">
             <tr><th>IP address</th><th>count</th><th>graf</th></tr>
              <?php
              $max = max($ip_accesses);
              $base = max(50, $max);
              arsort($ip_accesses);
              foreach ($ip_accesses as $ipaddress => $count){
                $width = ($count / $base) * 100;
                ?>
                <tr>
                    <td class="key"><?= $ipaddress ?></td>
                    <td class="count"><?= $count ?></td>
                    <td class="graf"><span style="width:<?=$width?>%;"></span></td>
                </tr>
              <?php } ?>
            </table>
        </div>
      </div>
  </details>
    </section>

</section>


</div><!-- inner -->
</main>
<script type="text/javascript">
</script>
</body>
</html>


