<?php
// GETで取れているか最初に確認する
// var_dump($_GET);
// exit();


session_start();
//関数用のファイルを読み込む
include('functions.php');
check_session_id();

// 送信されたidをgetで受け取る
$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();

//id名でテーブルから検索
$sql = 'SELECT * FROM item_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}
//レコード取得できているか確認する。取れていたらHTMLのinputに表示するのを書く
// var_dump($record);
// exit();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集ページ</title>
    <!-- Bootstrapの読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- googlefontsの読み込み -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>


    <legend>編集用ページ</legend>
    <a href="item_read.php">登録一覧</a><br>
    <br>
    <a href="index.php">ショップをみる</a>
    <form action="item_update.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="record">
                <div class="formItem">
                    <input type="file" name="image" accept="image/*">
                    <input type="hidden" name="image_old" accept="image/*" value="<?= $record["image"] ?>">
                </div>
                <div class=" formItem">
                    <label>
                        作品名<br> <input type="text" name="title" placeholder="さくひん名を入力" autocomplete=”off” value="<?= $record["title"] ?>">
                    </label>
                </div>
                <div class="formItem">
                    <label for="">作品の説明<br>
                        <textarea name="description" rows="4" cols="40" id="#result_text"><?= $record["description"] ?></textarea>
                    </label>
                    <a class="ecBtn" href=""><i class="fas fa-microphone" fa-lg></i></a>
                </div>
                <div class="formItem">
                    <label for="">
                        素材<input type="text" name="material" placeholder="そざいを入力" autocomplete=”off” value="<?= $record["material"] ?>">
                    </label>
                </div>
                <div class="formItem">
                    <label for="">
                        制作日 <input type="date" name="production_date" value="<?= $record["production_date"] ?>">
                    </label>
                </div>
                <div class="formItem">
                    <label for="">
                        制作した年齢 <input type="number" name="production_age" value="<?= $record["production_age"] ?>">
                    </label>
                </div>
                <div class="formItem">
                    <label for="">
                        金額 <input type="text" name="value" autocomplete=”off” value="<?= $record["value"] ?>">
                    </label>
                </div>
                <!-- idを見えないように送る input type="hidden"を使用する！-->
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
                <button class="btn">登録</button>
            </div>
        </fieldset>
    </form>
    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        const rec = new webkitSpeechRecognition();
        rec.continuous = true; // trueにすると連続的に認識する
        rec.interimResults = false; // trueにすると認識途中の結果も返す
        rec.lang = 'ja-JP'; // 言語を指定する
        rec.maxAlternatives = 10; // 結果候補の最大数(デフォルトは1)
        rec.onresult = e => {
            // 認識結果がSpeechRecognitionEventインスタンスとして渡される
            // 認識した言葉を表示
            console.log(e.results[0][0].transcript)
            const text = e.results[0][0].transcript;
            $("#result_text").val(text);
            rec.stop() // 認識が完了したら終了する
            //     for (let i = e.resultIndex; i < e.results.length; i++) {
            //         if (!e.results[i].isFinal) continue

            //         const {
            //             transcript
            //         } = e.results[i][0]
            //         console.log(`Recognised: ${transcript}`)
            //     }
            // }
            // rec.onend = () => {
            //     rec.start()
        }
        rec.start() // 認識を開始します
    </script>
</body>

</html>