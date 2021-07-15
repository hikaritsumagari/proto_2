<?php
session_start();
include("functions.php");
check_session_id();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>作品登録</title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <header>
    <div class="nav_wrap">
      <a href="ar_view.php" class="btn"><i class="fas fa-landmark fa-lg"></i></a>
      <a href="logout.php" class="btn">ログアウト</a>
    </div>
  </header>

  <main>
    <!-- POSTで送る、fileを送るときはenctypeは必ず必要！ -->
    <form action="file_upload.php" method="POST" enctype="multipart/form-data">
      <div>
        <!-- acceptでどんなファイルか指定/*で拡張子限らず全部の意味  caputure=でスマホカメラ起動できる -->
        <input type="file" multiple name="upfile" accept="image/*" capture="environment">
      </div>
      <div class="formItem">
        <label>
          作品名<br> <input type="text" name="title" placeholder="作品名" autocomplete=”off”>
        </label>
      </div>
      <div class="formItem">
        <label>説明<br>
          <textarea name="description" rows="6" cols="20" id="result_text" placeholder="説明"></textarea>
        </label>

        <select name="public">
          <option value="0"><i class="fas fa-lock"></i> 非公開</option>
          <option value="1"><i class="fas fa-globe-asia"></i> 公開</option>
        </select>

        <div>
          <button class="btn">登録</button>
        </div>
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