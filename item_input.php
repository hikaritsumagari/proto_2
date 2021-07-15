<?php
session_start();
include("functions.php");
check_session_id();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作品登録</title>
</head>

<body>


    <header>
        <h3>作品登録</h3>
        <a href="view.php" class="ecBtn">作品をみる</a>
        <a href="ar_view.php" class="ecBtn">美術館みる</a>
        <a href="logout.php" class="ecBtn">logout</a>
    </header>
    <main>
        <form action="item_create.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="record">
                    <div class="formItem">
                        <label>画像を選択 <br>
                            <input type="file" name="image" accept="image/*">
                        </label>
                    </div>
                    <div class="formItem">
                        <label>
                            作品名<br> <input type="text" name="title" placeholder="さくひん名を入力" autocomplete=”off”>
                        </label>
                    </div>
                    <div class="formItem">
                        <label for="">作品の説明<br>
                            <textarea name="description" rows="4" cols="40" id="result_text"></textarea><br>
                            <a class="ecBtn" href=""><i class="fas fa-microphone" fa-lg></i></a>
                        </label>

                    </div>
                    <div class="formItem">
                        <label for="">
                            素材<input type="text" name="material" placeholder="そざいを入力" autocomplete=”off”>
                        </label>
                    </div>
                    <div class="formItem">
                        <label for="">
                            制作日 <input type="date" name="production_date">
                        </label>
                    </div>
                    <div class="formItem">
                        <label for="">
                            制作した年齢 <input type="number" name="production_age">
                        </label>
                    </div>
                    <div class="formItem">
                        <label for="">
                            金額 <input type="text" name="value" autocomplete=”off”>
                        </label>
                    </div>
                    <button class="btn">登録</button>
                </div>
            </fieldset>
        </form>
    </main>
    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        // const rec = new webkitSpeechRecognition();
        // rec.continuous = true; // trueにすると連続的に認識する
        // rec.interimResults = false; // trueにすると認識途中の結果も返す
        // rec.lang = 'ja-JP'; // 言語を指定する
        // rec.maxAlternatives = 10; // 結果候補の最大数(デフォルトは1)
        // rec.onresult = e => {
        //     // 認識結果がSpeechRecognitionEventインスタンスとして渡される
        //     // 認識した言葉を表示
        //     // console.log(e.results[0][0].transcript)
        //     const text = e.results[0][0].transcript;
        //     $("#result_text").val(text);
        //     rec.stop() // 認識が完了したら終了する
        //     //     for (let i = e.resultIndex; i < e.results.length; i++) {
        //     //         if (!e.results[i].isFinal) continue

        //     //         const {
        //     //             transcript
        //     //         } = e.results[i][0]
        //     //         console.log(`Recognised: ${transcript}`)
        //     //     }
        //     // }
        //     // rec.onend = () => {
        //     //     rec.start()
        // }
        // rec.start() // 認識を開始します
    </script>
</body>

</html>