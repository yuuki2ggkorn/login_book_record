<?php
/* ユーザーデータ一覧画面の表示 */

include("funcs.php");  //funcs.phpを読み込む（関数群）
sschk();
//1.  DB接続します
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table;");
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
//    $view .= '<div class="book-container">';
//    $view .= '<div class="book-details">';
$view .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
$view .= '<tr>';
$view .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ユーザー名</th>';
$view .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ユーザーID</th>';
$view .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: left;">パスワード</th>';
$view .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: left;">操作</th>';
$view .= '</tr>';

$view .= '<tr>';
$view .= '<td style="border: 1px solid #ddd; padding: 8px;">' . h($res['name']) . '</td>';
$view .= '<td style="border: 1px solid #ddd; padding: 8px;">' . h($res['lid']) . '</td>';
$view .= '<td style="border: 1px solid #ddd; padding: 8px;">********</td>'; // パスワードの代わりにプレースホルダーを表示;
$view .= '<td style="border: 1px solid #ddd; padding: 8px;">';
$view .= '<a href="user_update.php?id=' . h($res['id']) . '" style="margin-right: 10px; padding: 5px 10px; color: red; text-decoration: none; border-radius: 5px;">編集</a>';
$view .= '</td>';
$view .= '</tr>';

$view .= '</table>';

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
          <a class="navbar-brand" href="user_add.php">ユーザー登録</a>
          <a class="navbar-brand" href="user_show.php">ユーザー表示</a>
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