<?php
include('functions.php');

// formのクリア条件
if (
    !isset($_POST['user_name']) || trim($_POST['user_name']) == '' ||
    !isset($_POST['email']) || $_POST['email'] == '' ||
    !isset($_POST['password']) || trim($_POST['password']) == ''
) {
    echo json_encode(["error_msg" => "no input"]);
    exit('Param Error');
}


$user_name = $_POST["user_name"];
$email = $_POST["email"];
$password = $_POST["password"];


$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM users_table WHERE user_name=:user_name';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}

if ($stmt->fetchColumn() > 0) {
    echo "<p>すでに登録されているユーザです．</p>";
    echo '<a href="login.php">login</a>';
    exit();
}

$sql = 'INSERT INTO users_table(user_id, user_name, email, password, user_img, is_deleted, created_at, updated_at) VALUES(NULL, :user_name, :email, :password, NULL, 0, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:login.php");
    exit();
}
