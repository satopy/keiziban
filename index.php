<?php
// POSTとして送信されてきたときのみ実行
// (通常アクセスはGET，フォーム送信はPOST)


function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

session_start(); // 1

$name = (string)filter_input(INPUT_POST, 'name');
$text = (string)filter_input(INPUT_POST, 'text');
$token = (string)filter_input(INPUT_POST, 'token'); // 3


$fp = fopen('data.csv', 'a+b'); // 1
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fputcsv($fp, [$_POST['name'], $_POST['text']]);
    rewind($fp); // 2
}
while ($row = fgetcsv($fp)) { // 3
    $rows[] = $row; // 4
}
fclose($fp);

?>


<!DOCTYPE html>

<meta charset="UTF-8">
<link rel="stylesheet" href="keiziban.css">
<title>Nちゃねえる</title>
<h7>N</h7><h11>ちゃんねる</h11>
<h1>[概要]</h1>

<div class="haikei1">
  <p>とりあえず、好きなこと書き込んでください。でも、この掲示板への迷惑行為。</p><br><p>エロチャはなしで。(するなら別の場所に移しておなしゃす。)</p>
</div>



<section>
    <h1>新規投稿</h1>
    <h3>(ニックネームと本文を記入してください)</h3>
    <form action="" method="post">
        名前: <input type="text" name="name" value=""><br>
        本文: <input type="text" name="text" value=""><br>
        <button type="submit">投稿</button>
    </form>
</section>
<section>
    <h2>投稿一覧</h2>
    <?php if (!empty($rows)): ?>
    <ul>
<?php foreach ($rows as $row): ?>
        <li><?=$row[1]?> (<?=$row[0]?>)</li>
<?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>投稿はまだありません</p>
    <?php endif; ?>


</section>
