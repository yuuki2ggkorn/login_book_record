<?php
/* 編集後のコメントをDBに再登録 */

//1. POSTデータ取得
$insert_dt = $_POST['insert_dt'];
$image_url = $_POST['image_url'];
$book_title = $_POST['book_title'];
$book_author = $_POST['book_author'];
$book_publisher = $_POST['book_publisher'];
$naiyou = $_POST['naiyou'];
$id    = $_POST["id"];   //idを取得

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数


//３．データ登録SQL作成
$sql = "UPDATE gs_bm_table SET insert_dt=:insert_dt, image_url=:image_url, book_title=:book_title, book_author=:book_author, book_publisher=:book_publisher, naiyou=:naiyou, indate=NOW() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':insert_dt',  $insert_dt,   PDO::PARAM_STR);  
$stmt->bindValue(':image_url', $image_url,  PDO::PARAM_STR);  
$stmt->bindValue(':book_title',   $book_title,    PDO::PARAM_STR); 
$stmt->bindValue(':book_author',   $book_author,    PDO::PARAM_STR); 
$stmt->bindValue(':book_publisher',   $book_publisher,    PDO::PARAM_STR);  
$stmt->bindValue(':naiyou',$naiyou, PDO::PARAM_STR);  
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}

?>
