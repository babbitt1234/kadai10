<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>書籍のアーカイブ</title>
  <link href="css/index.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<header>
  <nav>
    <div class="container-fluid">
    <div class="tittle">書籍のアーカイブ</div>
    </div>
  </nav>
</header>

<form method="post" action="insert.php" enctype="multipart/form-data">
 
  <div>
   <fieldset>
    <legend>書籍の登録</legend>
     <label>書籍の名前：<input type="text" name="name"></label><br>
     
      <label>カテゴリー：
         <select name="cat">
            <option value="小説、詩">小説、詩</option>
            <option value="ビジネス、経済">ビジネス、経済</option>
            <option value="哲学経済、思想">哲学経済、思想</option>
            <option value="コンピュータ、IT">コンピュータ、IT</option>
            <option value="アート、デザイン">アート、デザイン</option>
            <option value="その他">その他</option>
         </select>
     </label><br>
     
     <label>書籍のURL：<input type="text" name="url"></label><br>
     <label>画像：<input type="file" name="upfile"></label><br>
     <label>読んだ感想•コメント：<textArea name="coment" rows="4" cols="40"></textArea></label><br>
     <label>評価：
         <select name="eva">
            <option value="1">１</option>
            <option value="2">２</option>
            <option value="3" selected>３</option>
            <option value="4">４</option>
            <option value="5">５</option>
         </select>
     </label><br>
     <input type="submit" value="登録"><br>
    </fieldset>
    <div><a href="select_reg.php">登録一覧を見る</a></div>
  </div>
</form>

</body>
</html>
