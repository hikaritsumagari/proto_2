<?php
// POST届いたか確認する
// var_dump($_POST);
// exit();

session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();

// 各値をpostで受け取る
//受け取ったデータを$の変数に格納する（変数名は同じにしておくとわかりやすい）
$id = $_POST['id'];
$image_old = $_POST['image_old']; //画像 hiddenで渡した値を受け取る
$image = $_FILES['image']['name']; //画像名
$title = $_POST['title'];
$description = $_POST['description'];
$material = $_POST['material'];
$production_date = $_POST['production_date'];
$production_age = $_POST['production_age'];
$value = $_POST['value'];
// var_dump($image);
// exit();

//アップロード処理 imgフォルダの読み書き権限を確認すること！
$upload = "./img/";
if (move_uploaded_file($_FILES['image']['tmp_name'], $upload . $image)) {
    // echo 'アップロード成功';
} else {
    echo 'アップロード失敗';
    exit();
}

// var_dump($image_old);
// exit();


//DB接続
$pdo = connect_to_db();

// 更新するSQL文（UPDATE文）
//必ずWHEREでid名を指定すること！！全部更新されるのを防止
//バインド関数必要（ユーザーが書き込みするため）
//updated_atは更新した日時を入れるためsysdate()
$sql = "UPDATE item_table SET image=:image, title=:title, description=:description,material=:material,production_date=:production_date,production_age=:production_age,value=:value,
updated_at=sysdate() WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image', $image, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':material', $material, PDO::PARAM_STR);
$stmt->bindValue(':production_date', $production_date, PDO::PARAM_STR);
$stmt->bindValue(':production_age', $production_age, PDO::PARAM_INT);
$stmt->bindValue(':value', $value, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// echo $stmt->rowCount();
// var_dump($status);
// exit();

if ($image_old != $image) {
    if ($image_old != '') {
        unlink('./img' . $image_old);
    }
}
// var_dump($image_old);
// var_dump($image);
// exit();

if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:item_read.php");
    exit();
}
//DBも更新されているか確認する！
