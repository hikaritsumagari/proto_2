<?php
// まず確認する
// var_dump($_GET);
// exit();
session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();


// idをgetで受け取る
$id = $_GET['id'];

//関数用のファイルを読み込む
include('functions.php');
//DB接続
$pdo = connect_to_db();


//id名でテーブルから削除する
//WHEREで必ずid名を指定すること！全削除してしまうの防止！
$sql = 'DELETE FROM item_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 一覧を表示する
    header("Location:view.php");
}
//DBも更新されているか確認する！
