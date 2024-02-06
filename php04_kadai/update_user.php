<?php
/* ユーザー情報の更新をDBに登録 */

//1. POSTデータ取得
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$kanri_flg = $_POST['kanri_flg'];
$id    = $_POST["id"];   //idを取得

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
sschk();
$pdo = db_conn();      //DB接続関数

$hashed_password = password_hash($lpw, PASSWORD_DEFAULT);

//３．データ登録SQL作成
$sql = "UPDATE gs_user_table SET name=:name, lid=:lid, lpw=:lpw, kanri_flg=:kanri_flg, life_flg=0 WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',  $name,   PDO::PARAM_STR);  
$stmt->bindValue(':lid', $lid,  PDO::PARAM_STR);  
$stmt->bindValue(':lpw',   $hashed_password,    PDO::PARAM_STR); 
$stmt->bindValue(':kanri_flg',   $kanri_flg,    PDO::PARAM_INT); 
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("user_show.php");
}

?>
