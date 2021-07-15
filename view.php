<?php
session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();

// var_dump("ok");
// exit();

//DB接続
$pdo = connect_to_db();


// ---------*ランダム*----------
$sql = 'SELECT item_img,title,description FROM item_table WHERE user_id=? AND is_deleted=0 ORDER BY RAND() LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$rand = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = '';
foreach ($rand as $item) {
    // var_dump($rand);
    // exit;
    $rand_image .=
        '<div class="img_box">
            <img src="' . $item["item_img"] . '" class="rand_img">
            <ul class="title_box glass">
                <li>' . $item["title"] . ' </li>
                <li>' . $item["description"] . '</li>
            </ul>
        </div>';
}




//-------*メインギャラリー*---------
$sql = 'SELECT * FROM item_table WHERE user_id=? AND is_deleted=0 ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$status = $stmt->execute(); // SQLを実行 $statusに実行結果(取得したデータではない！)



// // 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗時にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  //fetchAllで全部とれる
    $output = '';
    foreach ($result as $record) {
        // var_dump($result);
        // exit;
        $output .= '<li>';
        $output .= '<img src="' . $record["item_img"] . '" class="item_img">';
        // $output .= '<h2>' . $record["title"] . '</h2>';
        // $output .= '<p>' . $record["description"] . '</p>';
        $output .= '</li>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>こども美術館</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="nav_wrap">
            <a href="xr_view.php" class="btn"><i class="fas fa-landmark fa-lg"></i></a>
            <a href="logout.php" class="btn">ログアウト</a>
        </div>
        <nav class="scroll-nav glass">
            <div class="scroll-nav__view">
                <form method='get' action="ajax_get.php">
                    <ul class="scroll-nav__list">
                        <li class="scroll-nav__item"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2021" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2020" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                    </ul>
                </form>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <?= $rand_image ?>
        </section>

        <section>
            <ul class="grid">
                <!-- ここに<li>でphpデータが入る -->
                <?= $output ?>
            </ul>
        </section>

    </main>

    <footer>
        <div class="nav_bottom">
            <a href="view.php" class="btn"><i class="fas fa-home fa-lg"></i></a>
            <a href="file_upform.php" class="btn "><i class="fas fa-plus-square fa-lg"></i></a>
            <a href="child.php" class="btn"><i class="fas fa-user-alt fa-lg"></i></a>
        </div>
    </footer>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>

</html>