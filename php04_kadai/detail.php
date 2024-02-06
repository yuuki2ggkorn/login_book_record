<?php
//１．PHP
//select.phpの[PHPコードだけ！]をマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。

/* データ一覧画面の表示 */
$id = $_GET["id"];
include("funcs.php");  //funcs.phpを読み込む（関数群）
sschk();
//1.  DB接続します
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  //SQLエラーの場合
  sql_error($stmt);
} else {

  //SQL成功の場合
  $row = $stmt->fetch();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }
  </style>
  <style>
    body {
      text-align: center;
      background-color: #d1c0b5;
    }

    header,
    main,
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .navbar {
      width: 100%;
      justify-content: center;
    }

    .navbar-header {
      display: flex;
      justify-content: center;
    }

    .jumbotron {
      width: 100%;
      margin: 0;
      padding: 15px;
    }

    .book-container {
      display: flex;
      padding: 0.5rem;
      /* 8px if 1rem = 16px */
      border: 1px solid #D1D5DB;
      /* Tailwindのborder-gray-300に相当 */
      margin-bottom: 0.5rem;
      /* 8px if 1rem = 16px */
      background-color: #ffffff;
    }
  </style>
</head>

<body>

  <!-- Head[Start] -->
  <header>
    <h1>読書記録</h1>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">書籍検索</a>
          <a class="navbar-brand" href="select.php">記録一覧</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- 書籍情報表示 -->
  <div class="book-container">
    <img src="<?= $row["image_url"] ?>" class="book-thumbnail"/>
    <div class="book-details">
      <h2 class="book-title"><?= $row["book_title"] ?></h2>
      <p class="book-author"><?= $row["book_author"] ?></p>
      <p class="book-publisher"><?= $row["book_publisher"] ?></p>
    </div>
  </div>
  <!-- Main[Start] -->
  <form method="POST" action="update.php">
    <div class="jumbotron">
      <fieldset>
        <legend>コメント</legend>
        <input type="hidden" name="insert_dt" id="insert_dt" value="<?= $row["insert_dt"] ?>">
        <input type="hidden" name="image_url" id="image_url" value="<?= $row["image_url"] ?>">
        <input type="hidden" name="book_title" id="book_title" value="<?= $row["book_title"] ?>">
        <input type="hidden" name="book_author" id="book_author" value="<?= $row["book_author"] ?>">
        <input type="hidden" name="book_publisher" id="book_publisher" value="<?= $row["book_publisher"] ?>">
        <label><textArea name="naiyou" rows="4" cols="40" id="comment"><?= $row["naiyou"] ?></textArea></label><br>
        <input type="hidden" name="id" value="<?=$row["id"]?>">
        <input type="submit" value="登録">
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->


</body>

</html>