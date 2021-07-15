<?php
// var_dump($_POST);
// exit();

session_start();
include('functions.php');

//入力チェック 未入力はエラー 必ず挙動確認すること
if (
    !isset($_POST['child_name']) || $_POST['child_name'] == ''
) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

$child_name = $_POST["child_name"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];

// 日付（date）の結合
$child_birthday = "$year-$month-$day";
// exit('ok');

$pdo = connect_to_db();

// $sql = 'SELECT * FROM users_table WHERE user_id=?';
// $stmt = $pdo->prepare($sql);
// $status = $stmt->execute();


$sql = 'INSERT INTO child_table(child_id, user_id, child_name, child_birthday, child_img, is_deleted, created_at, updated_at) VALUES(NULL, :user_id, :child_name, :child_birthday, NULL, 0, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
$stmt->bindValue(':child_name', $child_name, PDO::PARAM_STR);
$stmt->bindValue(':child_birthday', $child_birthday, PDO::PARAM_STR);
$status = $stmt->execute();


if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $_SESSION["child_id"] = $val["child_id"];
    $_SESSION["child_birthday"] = $val["child_birthday"];
    header("Location:view.php");
    exit();
}
