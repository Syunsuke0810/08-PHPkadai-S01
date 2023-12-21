<?php

$id = $_GET['id'];

//2. DB接続します
//*** function化する！  *****************


try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

// require_once('funcs.php');
// $pdo = db_conn();

//３．データ登録のアップデート
$stmt = $pdo->prepare( 'DELETE  FROM gs_bm_table WHERE id =:id; ');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location:select1.php');
    exit();
}
