<?php

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */

$id = $_GET['id'];

try {
  $db_name = 'gs_db';    //データベース名
  $db_id   = 'root';      //アカウント名
  $db_pw   = '';      //パスワード：MAMPは'root'
  $db_host = 'localhost'; //DBホスト
  $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB Connection Error:' . $e->getMessage());
}

// require_once('funcs.php');
// $pdo = db_conn();


//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bm_table WHERE id = :id;');
$stmt ->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
} else {
  // 成功した場合
  $result = $stmt->fetch();
}
// echo '<pre>';
// var_dump($result);
// echo '</pre>';

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>フリーアンケート</legend>
                <label>書籍名：<input type="text" name="bookname" value="<?= $result['bookname'] ?>"></label><br>
                <label>書籍URL：<input type="text" name="bookurl"  value="<?=$result['bookurl']?>"></label><br>
                <label><textarea name="booktext" rows="4" cols="40"  ><?=$result['booktext']?></textarea></label><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">
                <input type="submit" value="更新">
            </fieldset>
        </div>
    </form>
</body>

</html>
