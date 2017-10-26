<?php
include("functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["url"]) || $_POST["url"]=="" ||
  !isset($_POST["coment"]) || $_POST["coment"]=="" ||
  !isset($_POST["eva"]) || $_POST["eva"]=="" ||
  !isset($_POST["cat"]) || $_POST["cat"]==""
){
  exit('ParamError');
}

//1. POST受信
$name = $_POST["name"];
$url = $_POST["url"];
$coment = $_POST["coment"];
$eva = $_POST["eva"];
$cat = $_POST["cat"];

if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
    //情報取得
    $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
    $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
    $file_dir_path = "upload/";  //画像ファイル保管先

    
    //***File名の変更***
    $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
    $file_name = date("YmdHis").md5(session_id()) . "." . $extension;  //ユニークファイル名作成
    

    $img="";  //画像表示orError文字を保持する変数
    // FileUpload [--Start--]
    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path . $file_name ) ) {
            chmod( $file_dir_path . $file_name, 0644 );
            //echo $file_name . "をアップロードしました。";
            //$img = '<img width="300" src="'. $file_dir_path . $file_name . '" >'; //画像表示用HTML
        } else {
            //$img = "Error:アップロードできませんでした。"; //Error文字
        }
    }
    // FileUpload [--End--]
}else{
    //$img = "画像が送信されていません"; //Error文字
}

//2.DB接続（エラー処理追加）
try {
//  $pdo = new PDO('mysql:dbname=gs_db30;charset=utf8;host=localhost','root','');
  $pdo = new PDO('mysql:dbname=gs_db30;charset=utf8;host=127.0.0.1','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//3．SQLを作って実行
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, url, coment,
indate, image, eva, cat)
VALUES(NULL, :name, :url, :coment, sysdate(), :image, :eva, :cat)");

//データを渡す
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':coment', $coment, PDO::PARAM_STR);
$stmt->bindValue(':image', $file_name, PDO::PARAM_STR);
$stmt->bindValue(':eva', $eva, PDO::PARAM_INT);
$stmt->bindValue(':cat', $cat, PDO::PARAM_STR);

//SQL実行
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  //2に読める英語が入る
  exit("QueryError:".$error[2]);
}else{
//5.index.phpへリダイレクト
  header("Location: index_man.php");
  exit;
}
?>