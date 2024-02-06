<?php
/* データ一覧画面の表示 */
session_start();
include("funcs.php");  //funcs.phpを読み込む（関数群）
sschk();
//1.  DB接続します
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table;");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_Error:" . $error[2]);
} else {
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<div class="book-container">';
    $view .= '<img src="' . h($res['image_url']) . '" class="book-thumbnail" style="height:auto; float:left; margin-right:10px;"/>';
    $view .= '<div class="book-details">';
    $view .= '<h2 class="book-title">' . h($res['book_title']) . '</h2>';
    $view .= '<p class="book-author">' . h($res['book_author']) . '</p>';
    $view .= '<p class="book-publisher">' . h($res['book_publisher']) . '</p>';
    $view .= '<p class="book-description">' . h($res['naiyou']) . '</p>';
    $view .= '</div>'; // book-details の終了タグ

    $view .= '<div class="button-container" style="margin-top: 10px;">';
    $view .= '<div class="det-button" style="margin-top: 10px;">';
    // 編集ボタン
    $view .= '<a href="detail.php?id=' . h($res['id']) . '" class="edit-button">編集</a>';
    $view .= '</div>';
    $view .= '<div class="del-button" style="margin-top: 10px;">';

    // 削除ボタン
    $view .= '<a href="delete.php?id=' . h($res['id']) . '" class="delete-button" onclick="return confirm(\'本当に削除しますか？\');">削除</a>';
    $view .= '</div>';

    $view .= '</div>'; // button-container の終了タグ

    $view .= '<div style="clear:both;"></div>'; // クリアフロート
    $view .= '</div>'; // book-container の終了タグ
  }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>読書記録表示</title>
  <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }
  </style>
</head>
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
    background-color: #d1c0b5;
  }

  .book-container {
    display: flex;
    padding: 0.5rem;
    /* 8px if 1rem = 16px */
    border: 1px solid #D1D5DB;
    /* Tailwindのborder-gray-300に相当 */
    margin-bottom: 0.5rem;
    /* 8px if 1rem = 16px */
    background-color: #eeeeee;
  }
</style>

<body id="main">
  <!-- Head[Start] -->
  <header>
    <h1>読書記録</h1>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">書籍検索</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <div>
    <div class="content"><?= $view ?></div>
  </div>
  <!-- Main[End] -->

</body>

</html>