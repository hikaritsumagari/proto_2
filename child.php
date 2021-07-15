<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();


$stmt = $pdo->prepare('SELECT * FROM child_table WHERE user_id=?');
$stmt->execute([$_SESSION['user_id']]);
$my_page = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if (isset($_SESSION['user_name'])) {
//     header('Location:login.php');
//     exit;
// } else {
//     echo '';
// }


for ($i = 2000; $i <= 2025; $i++) {
    $year .= '<option value="' . $i . '">' . $i . '年</option>';
}

for ($i = 1; $i <= 12; $i++) {
    $month .= '<option value="' . $i . '">' . $i . '月</option>';
}

for ($i = 1; $i <= 31; $i++) {
    $day .= '<option value="' . $i . '">' . $i . '日</option>';
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お子さま情報</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="nav_wrap">
            <a href="xr_view.php" class="btn"><i class="fas fa-landmark fa-lg"></i></a>
            <a href="logout.php" class="btn">ログアウト</a>
        </div>
    </header>

    <main>
        <form action="child_act.php" method="POST" autocomplete="off">

            <div>
                お子さまのお名前 <input type="text" name="child_name">
            </div>

            <div>
                お誕生日 <br>
                <select name="year"><?= $year ?></select>
                <select name="month"><?= $month ?></select>
                <select name="day"><?= $day ?></select>
            </div>

            <div>
                <button class="btn">登録する</button>
            </div>
            <a href="view.php">もどる</a>
        </form>
    </main>
    <footer>
        <div class="nav_bottom">
            <a href="view.php" class="btn"><i class="fas fa-home fa-lg"></i></a>
            <a href="file_upform.php" class="btn"><i class="fas fa-plus-square fa-lg"></i></a>
            <a href="child.php" class="btn"><i class="fas fa-user-alt fa-lg"></i></a>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
</body>

</html>