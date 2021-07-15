<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <!-- Bootstrapの読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- googlefontsの読み込み -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <!-- action と method 忘れずに！ -->
    <form action="login_act.php" method="post" autocomplete="off">
        <fieldset>
            <legend>ログイン画面</legend>
            <div>
                <!-- name属性わすれずに！dbと同じにする -->
                ユーザーネーム <input type="text" name="user_name">
            </div>
            <div>
                パスワード <input type="password" name="password">
            </div>
            <div>
                <button class="btn">ログイン</button>
            </div>
            <a href="signup.php">新規登録する</a>
        </fieldset>
    </form>

</body>

</html>