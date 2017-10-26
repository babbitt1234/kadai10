<?php
session_start();

//0.外部ファイル読み込み
include("functions.php");

//POST
if(!isset($_POST["search"]) || $_POST["search"]==""){
    $s = "";
}else{
    $s = $_POST["search"];
}

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
if($s!=""){
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE name LIKE :s");
    $stmt->bindValue(":s", "%".$s."%", PDO::PARAM_STR);
}else{
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table"); 
}
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
    echo "false";
}else{
    //Selectデータの数だけ自動でループしてくれる
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      $view .="<tr>";
      $view .="<td>";
      $view .=$result["indate"];
      $view .="</td>";
      $view .="<td>";
      $view .='<img src="upload/'.$result["image"].'" style="width:120px;">';
      $view .="</td>";
      $view .="<td>";
      $view .='<a href="bm_detail_view.php?id='.$result["id"].'">'.$result["name"].'</a>';
      $view .="</td>";
      $view .="<td>";
      $view .=$result["url"];
      $view .="</td>";
      $view .="<td>";
      $view .=$result["coment"];
      $view .="</td>";
      $view .='<td>';
      $view .='<a href="delete.php?id='.$result["id"].'">'.'[削除]'.'</a>';
      $view .="</td>";
      $view .="</tr>";
    }
    echo 
      "<tr>
      <th>時間</th>
      <th>画像</th>
      <th>書籍の名前</th>
      <th>書籍のURL</th>
      <th>読んだ感想•コメント</th>
      <th>削除</th>
      </tr>".$view;
}
?>
