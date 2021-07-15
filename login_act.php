<?php
//まず確認
// var_dump($_POST);
// exit();

//dbの構造をかくにんすること
//最初にセッションスタート
session_start();
include('functions.php');

//値を受け取る
$user_name = $_POST['user_name'];
$password = $_POST['password'];

//db連携
$pdo = connect_to_db();

$sql = 'SELECT * FROM users_table WHERE user_name=:user_name AND password=:password AND is_deleted=0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();
// var_dump($status);
// exit();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$val) {
        echo "<p>ログイン情報に誤りがあります</p>";
        echo "<a href=login.php>ログイン</a>";
        exit();
    } else {
        $_SESSION = array();
        $_SESSION["session_id"] = session_id();
        $_SESSION["user_id"] = $val["user_id"];
        $_SESSION["user_name"] = $val["user_name"];
        $_SESSION["EMAIL"] = $val["email"];
        header("Location:view.php");
        exit();
    }
}
