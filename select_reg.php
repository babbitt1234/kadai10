<?php
session_start();

include("functions.php");
ssidChk();

//1.DB接続 
try {
  $pdo = new PDO('mysql:dbname=gs_db30;charset=utf8;host=127.0.0.1','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//2.データ登録SQL
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY id DESC");
//SQL実行
$status = $stmt->execute();

//3.データ表示
$view = "";
if($status==false){
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //selectデータの数だけ自動でループしてくれる
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      $view .="<tr>";
      $view .="<td>";
      $view .=$result["indate"];
      $view .="</td>";
      $view .="<td>";
      $view .='<img src="upload/'.$result["image"].'" style="width:120px;">';
      $view .="</td>";
      $view .="<td>";
      $view .='<a href="bm_update_view.php?id='.$result["id"].'">'.$result["name"].'</a>';
      $view .="</td>";
      $view .="<td>";
      $view .=$result["cat"];
      $view .="</td>";
      $view .="<td>";
      $view .=$result["url"];
      $view .="</td>";
      $view .="<td>";
      $view .=$result["coment"];
      $view .="</td>";
      $view .="<td>";
      $view .=$result["eva"];
      $view .="</td>";
      $view .='<td>';
      $view .='<a href="delete.php?id='.$result["id"].'">'.'[削除]'.'</a>';
      $view .="</td>";
      $view .="</tr>";

  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>書籍のアーカイブ</title>
<link href="css/select_reg1.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
<!--
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/jquery.quicksearch.js" type="text/javascript"></script>
-->
<header>
    <div class="container-fluid">
      <div class="tittle">書籍のアーカイブ</div>
      <div><a href="logout.php">ログアウト</a></div>
    </div>
</header>
<div>ようこそ<?=$_SESSION["name"]?>様</div>
<p>書籍登録一覧</p>
<!--
<form action="#">
    <p>書籍登録書籍検索　<input type="text" name="search" value="" id="search" /></p>
</form>
-->
<input type="text" placeholder="書籍名検索" id="search">
<button id="search_btn">検索</button>
<table id="view">
<tr>
<th>時間</th>
<th>画像</th>
<th>書籍の名前</th>
<th>カテゴリー</th>
<th>書籍のURL</th>
<th>読んだ感想•コメント</th>
<th>評価</th>
<th>削除</th>
</tr>
<?=$view?>
</table>

<div>※タイトル（書籍の名前）をクリックすると内容を変更できます</div>
<div><a class="navbar-brand" href="index.php">書籍登録画面</a></div>

<!--
<script>
    $(function(){
        $('input#search').quicksearch('table tbody tr');
    });
</script>
-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>
$("#search_btn").on("click",function(){
    $.ajax({
        type: "POST",
        url: "search_reg.php",
        data: { search:$("#search").val() },
        datatype: "html",
        success: function(data){
            $("#view").html(data);
        }
    });
});

</script>
</body>
</html>
