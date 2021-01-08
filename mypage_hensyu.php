<?php
mb_internal_encoding("utf8");

//セッションスタート
session_start();

//mypage.phpからの導線以外は、login_error.phpへリダイレクト
$_SESSION['from_mypage'] = $_POST['from_mypage'];

if(!isset($_SESSION['from_mypage'])){
    header("Location:login_error.php");
}

?>

<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>マイページ登録</title>
        <link rel="stylesheet" type="text/css" href="mypage_hensyu.css">
    </head>
    
    <body>
        <!-- マイページとして表示する部分の記述 -->
        <!-- HTMLとsessionを記述。編集できるように、sessionはvalueに入れる。 -->
        <!-- http://localhost/login_mypage/mypage_hensyu.php -->
        
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="logout"><a href="log_out.php">ログアウト</a></div>
        </header>
        
        <main>
            <form action="mypage_update.php" method="post">
                <div class="MypageInfo">
                    <h2>会員情報</h2>
                    <div class="hello">
                        <?php echo "こんにちは！".$_SESSION['name']."さん"; ?>
                    </div>
                    
                    <div class="profile_pic">
                        <img src="<?php echo $_SESSION['picture']; ?>">
                    </div>
                    
                    <div class="BasicInfo">
                        <p>氏名：<input type="text" size="30" value="<?php echo $_SESSION['name']; ?>" name="name"></p>
                        <p>メール：<input type="text" size="30" value="<?php echo $_SESSION['mail']; ?>" name="mail"></p>
                        <p>パスワード：<input type="text" size="30" value="<?php echo $_SESSION['password']; ?>" name="password"></p>
                    </div>
                    
                    <div class="comments">
                        <textarea rows="5" cols="60" name="comments"><?php echo $_SESSION['comments']; ?></textarea>
                    </div>
                    
                    <div class="Button">
                        <input type="submit" class="HenkouButton" size="35" value="この内容に変更する">
                    </div>
                </div>
            </form>
        </main>
    </body>
    
    <footer>
        ©️2018 InterNous.inc.All rights reserved
    </footer>
</html>