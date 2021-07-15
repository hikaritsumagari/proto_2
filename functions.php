<?php

//DB接続のための関数
function connect_to_db()
{
    // DB接続情報  dbnameを自分のデータベース名にする
    //$user,$pwdは初期値（レンタルサーバー等のときは適宜変更する）
    $dbn = 'mysql:dbname=gs_prototype_01;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
    // DB接続 「return」がある
    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:' . $e->getMessage());
    }
}


// ログイン状態のチェック関数
function check_session_id()
{
    // 失敗時はログイン画面に戻るようにする
    // session_idがないとき||idが一致しないとき
    if (!isset($_SESSION['session_id']) || $_SESSION['session_id'] != session_id()) {
        header('Location: login.php');
        // echo 'ログインしてません';
        exit();
        // ログイン画面へ移動
    } else {
        session_regenerate_id(true); // セッションidの再生成
        $_SESSION['session_id'] = session_id(); // セッション変数上書き
    }
}
