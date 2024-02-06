# 作成メモ

## ファイル
### index.php
* UI
* name作成
* insertにpost
* descriptionにエラーあり（authorなしで止まる）

### insert.php
* indexのデータを_POST
* DB接続
* SQL操作でデータ登録
* エラーがなければindexのUIへ

### select.php
* DB接続
* データ抽出SQL操作
* phpとhtmlでデータ表示を実装

### detail.php
* selectから飛べる
* idをgetしてdb読み込み
* update.phpに繋ぐ(データをpost)

### delete.php
* idをgetしてdbから削除（クエリ実行）

### update.php
* postされたデータをdbに登録

### funcs.php
* view作成用の関数
* 色々関数を入れてある

### login.php


### login_act.php


### logout.php

## 知ったこと
### dbのデータ保存先
* /xammpfiles/var/mysql
* xammpのmysqlがstartできない時は（MAC）
`sudo lsof -i :3306`
で何かプロセスがあれば
`sudo kill xxxxx`


## 作りたいもの
1. 読んだ本のタイトル検索：index.html  
* 検索窓
* 検索ボタン（enter ok）
* 結果表示領域
* 登録書籍一覧ボタン
* ⭐︎（可能であれば）右側に登録ずみの本画像表示→ホバーで内容表示→表示内にコメント→クリックするとページ遷移・編集、削除機能ありで

2. 対象の本を選択：index.html  
* 選択領域の設定

3. 対象の本だけが残る：index.html  
* ホバーの設定
* 選択された物以外を表示から削除

4. UIの下部にコメントの入力欄と保存ボタンが表示される：index.html  
* 条件によるコメントの表示機能
* 条件による保存ボタンの表示機能
* コメントがない場合、保存ボタンを押せない（色が変わらない）

5. コメントを書いたら保存できる：index.html  
* 条件による保存ボタンのactivate（enter NG）
* 必要な情報をfieldset：（画像）、書籍名、著者名、登録日時、コメント
* insert.phpにpost
* insert.phpでデータをgs_bm_tableに登録

6. 登録完了のポップアップ：index.html  
* 保存ボタン押したら画面に表示->(できれば)ポップアップの関数作る

7. 最初の画面に戻る：index.html  
* reload or 削除?
* ポップアップだけ消す
* データの確認（phpmyadmin->dbの中身） DBとsqlの型の違いが原因でした...

8. 登録書籍一覧ボタンでページ遷移：index.html  
* select.phpを作っておく

9. 登録済みの本を一覧で表示：select.php
* header, hooterは変えない
* select.phpの要領で表示
* index.phpへの戻りボタンをつけておく

#### 以下、課題03
10. それぞれの本に削除とコメント編集機能をつける
* 削除ボタンを各本に作成
* （できれば）ボタン押すと確認のポップアップできる
* gs_bm_tableにsql送ってdelete：delete.php

* 編集ボタンを各本に作成
* 編集ボタンを押すと、コメントが書き換えられるようになる：detail.php
* okを押すとdb書き換えsqlが走る：update.php
* （できれば）キャンセルとokボタンがあると良い


#### 以下、課題04
11. loginの実装
* login.phpを作成
* UIを統一

12. login認証を作成
* ユーザデータ登録用のDBを作成
* ハッシュ化対応->login_act.phpの$pwを変更



デプロイ時
* gs_user_tableのDBを登録

## アディショナル
* サイトUIの設定
* DB情報を設定ファイルに置く（セキュリティ）
* 必要であれば日時のタイムゾーン、型
* DBのエラー
`2024-01-21  1:49:33 547 [ERROR] Incorrect definition of table mysql.column_stats: expected column 'max_value' at position 4 to have type varbinary(255), found type varchar(255).`


insert_dt=2024-01-22T16%3A01%3A17.822Z&
image_url=http%3A%2F%2Fbooks.google.com%2Fbooks%2Fcontent%3Fid%3DyMdjCgAAQBAJ%26printsec%3Dfrontcover%26img%3D1%26zoom%3D1%26edge%3Dcurl%26source%3Dgbs_api&
book_title=NTT%E3%82%B3%E3%83%9F%E3%83%A5%E3%83%8B%E3%82%B1%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%BA%20Enterprise%20Cloud%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E6%A7%8B%E7%AF%89%E3%82%AC%E3%82%A4%E3%83%89&
book_author=%E8%91%97%E8%80%85%3A%20NTT%E3%82%B3%E3%83%9F%E3%83%A5%E3%83%8B%E3%82%B1%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%BA%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE&
book_publisher=%E5%87%BA%E7%89%88%E7%A4%BE%3A%20%E7%BF%94%E6%B3%B3%E7%A4%BE&
naiyou=%E3%80%81%E3%80%81%E3%80%81%E3%80%81


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<style>div{padding: 10px;font-size:16px;}</style>
<title>ログイン</title>
</head>
<body>

<header>
<h1>読書記録</h1>
  <nav class="navbar navbar-default">LOGIN</nav>
</header>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="login_act.php" method="post">
ID:<input type="text" name="lid" />
PW:<input type="password" name="lpw" />
<input type="submit" value="LOGIN" />
</form>


</body>
</html>