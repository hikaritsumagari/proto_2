<?php
//必ず確認 POSTで送信された値は必ず$_POSTで受け取る
// var_dump($_FILES);
// exit();

session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();

//入力チェック 未入力はエラー 必ず挙動確認すること
if (
    !isset($_FILES['image']['name']) || $_FILES['image']['name'] == '' ||
    !isset($_POST['title']) || $_POST['title'] == '' ||
    !isset($_POST['description']) || $_POST['description'] == '' ||
    !isset($_POST['material']) || $_POST['material'] == '' ||
    !isset($_POST['production_date']) || $_POST['production_date'] == '' ||
    !isset($_POST['production_age']) || $_POST['production_age'] == '' ||
    !isset($_POST['value']) || $_POST['value'] == ''
) {
    exit('ParamError');
}

//受け取ったデータを$の変数に格納する（変数名は同じにしておくとわかりやすい）
$image = $_FILES['image']['name']; //画像名
$title = $_POST['title'];
$description = $_POST['description'];
$material = $_POST['material'];
$production_date = $_POST['production_date'];
$production_age = $_POST['production_age'];
$value = $_POST['value'];

//アップロード処理 imgフォルダの読み書き権限を確認すること！
$upload = "./img/";
if (move_uploaded_file($_FILES['image']['tmp_name'], $upload . $image)) {
    // echo 'アップロード成功';
} else {
    echo 'アップロード失敗';
}
// exit();



//DB接続
$pdo = connect_to_db();


//SQL作成と実行 SQL文は必ず文字列で入力すること
//変数をバインド変数(:todo)に格納する（セキュリティ）
$sql = 'INSERT INTO
item_table(id, image, title, description, material, production_date, production_age, value, created_at, updated_at)
VALUES(NULL, :image, :title, :description, :material, :production_date, :production_age, :value, sysdate(), sysdate())';

//int型は「PARAM::INT」にする
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image', $image, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':material', $material, PDO::PARAM_STR);
$stmt->bindValue(':production_date', $production_date, PDO::PARAM_STR);
$stmt->bindValue(':production_age', $production_age, PDO::PARAM_INT);
$stmt->bindValue(':value', $value, PDO::PARAM_INT);
$status = $stmt->execute(); // SQLを実行


// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();
    // データ登録失敗時にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    // 登録ページへ移動
    header('Location:item_input.php');
}
