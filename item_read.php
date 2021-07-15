<?php
session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();

//DB接続
$pdo = connect_to_db();

//SQLで参照
$sql = 'SELECT * FROM item_table ORDER BY created_at ASC';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); // SQLを実行 $statusに実行結果(取得したデータではない！)


// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗時にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  //fetchAllで全部とれる
    $output = '';
    //繰り返し文（foreach以外）でもOK
    foreach ($result as $record) {
        // var_dump($result);
        // exit;
        $output .= '<li class="border">';
        $output .= '<div class="flex"><div class="imgBox"><img src="img/' . $record["image"] . '" ></div>';
        $output .= '<div class="descriptiionList"><h2>作品名 : ' . $record["title"] . '</h2>';
        $output .= '<p>素材 :  ' . $record["material"] . ' 制作日 : ' . $record["production_date"] . ' 制作した年齢 : ' . $record["production_age"] . ' 歳</p>';
        $output .= '<p>作品の説明 : ' . $record["description"] . '</p>';
        // edit deleteリンクを追加
        $output .= "<a href='item_edit.php?id={$record["id"]}' class='btn'>編集</a>";
        $output .= "<a href='item_delete.php?id={$record["id"]}' class='btn'>削除</a></div>";
        $output .= '</li>';
    }
    // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一覧</title>
    <!-- Bootstrapの読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- googlefontsの読み込み -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>


<body>
    <header>
        <h3>一覧</h3>
        <a href="ar_view.php" class="ecBtn">美術館</a>
        <a href="kodomo_logout.php" class="ecBtn">logout</a>

    </header>
    <main>
        <a href="item_input.php">作品を登録する</a><br>
        <a href="shop.php">ショップをみる</a>
        <ul>
            <!-- ここに<li>でphpデータが入る -->
            <?= $output ?>
        </ul>
    </main>
</body>

</html>