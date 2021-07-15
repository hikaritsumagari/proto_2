<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <form action="signup_act.php" method="POST" autocomplete="off">

        <div>
            ユーザーネーム <input type="text" name="user_name">
        </div>

        <div>
            メールアドレス <input type="email" name="email">
        </div>

        <div>
            パスワード <input type="password" name="password">
        </div>


        <div>
            <button class="btn">登録する</button>
        </div>
        <a href="login.php">ログイン画面</a>

    </form>

</body>

</html>