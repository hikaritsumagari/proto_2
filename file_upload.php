<?php
session_start();
include("functions.php");
check_session_id();


if (
  !isset($_FILES['upfile']['name']) || $_FILES['upfile']['name'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$title = $_POST['title'];
$description = $_POST['description'];
$public = $_POST['public'];


// ここからファイルアップロード&DB登録の処理を追加しよう！！！
// 必ず確認
// var_dump($_FILES);
// exit();

if ($_FILES['upfile']['error'] !== 4) {
  if ($_FILES['upfile']['error'] == 0) {
    $uploaded_file_name = $_FILES['upfile']['name']; //ファイル名の取得
    $temp_path = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
    $directory_path = 'img/';
    $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
    $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
    $filename_to_save = $directory_path . $unique_name;
    // 長い画像名になっているか確認してみる
    // var_dump($filename_to_save);
    // exit();

    if (is_uploaded_file($temp_path)) {
      // ↓ここでtmpファイルを移動する
      if (move_uploaded_file($temp_path, $filename_to_save)) {
        chmod($filename_to_save, 0644); // 権限の変更
      } else {
        exit('エラー！保存できませんでした'); // 画像の保存に失敗
      }
    } else {
      exit('エラー！画像がないです'); // tmpフォルダにデータがない
    }
  } else {
    //送信されていない場合、エラーの場合
    exit('エラー！アップロードに失敗しました');
  }
} else {
  $filename_to_save = '';
}


//jpegの撮影日を取得する(date形式Y-m-dで保存）

$exif = @exif_read_data($filename_to_save, null, true);
// var_dump($exif['DateTimeOriginal']);
// exit();

if (isset($exif['EXIF']['DateTimeOriginal'])) {

  $exifDatePattern = '/\A(?<year>\d{4}):(?<month>\d{1,2}):(?<day>\d{1,2}) (?<hour>\d{2}):(?<minute>\d{2}):(?<second>\d{2})\z/';

  if (preg_match($exifDatePattern, $exif['EXIF']['DateTimeOriginal'], $matches)) {
    $dateTime = new \DateTime(sprintf(
      '%d-%d-%d %d:%d:%d',
      $matches['year'],
      $matches['month'],
      $matches['day'],
      $matches['hour'],
      $matches['minute'],
      $matches['second']
    ));
    $exif_date = $dateTime->format('Y-m-d');
    $exif_year = $dateTime->format('Y');
    // var_dump($exif_year);
    // exit();
  }
} else {
  // exit('エラー！JPEG形式ではありません');
  //exifデータがないときはアップロードした日を入れる
  $exif_date = date('Y-m-d');
  $exif_year = date('Y');
}

// var_dump($exif_year);
// exit();


// db連携
$pdo = connect_to_db();

$stmt = $pdo->prepare('SELECT * FROM users_table WHERE user_id=?');
$stmt->execute([$_SESSION['user_id']]);
// $stmt->execute([$_SESSION['child_id']]);
$status = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($status);
// exit();


$sql = 'INSERT INTO item_table(item_id, user_id, item_img, exif_date, exif_year, title, description, public, is_deleted, created_at, updated_at) VALUES(NULL, :user_id, :item_img, :exif_date, :exif_year, :title, :description, :public, 0, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);

// item_imgカラムには、画像ファイルのパスが入る
$stmt->bindValue(':item_img', $filename_to_save, PDO::PARAM_STR);
$stmt->bindValue(':exif_date', $exif_date, PDO::PARAM_STR);
$stmt->bindValue(':exif_year', $exif_year, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':public', $public, PDO::PARAM_INT);
$status = $stmt->execute();

// var_dump($stmt);
// exit();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:view.php");
  exit();
}
