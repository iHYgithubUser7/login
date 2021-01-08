<?php
session_start();

//ログイン時にアクセスした場合、マイページへリダイレクト
if(isset($_SESSION['id'])){
    header("Location:mypage.php");
}
?>

<!doctype html>
<html lang="ja">
    
    <head>
        <meta charset="utf-8">
        <title>ログイン</title>
        <link rel="stylesheet" type="text/css" href="login.css">
    </head>
    
    <!-- http://localhost/login_mypage/login_error.php -->
    
    <body>
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="login">
                <a href="login.php">ログイン</a>
            </div>
        </header>
        
        <main>
            <form action="mypage.php" method="post">
                <div class="contents">
                    
                    <div class="ErrorMessage">メールアドレスまたはパスワードが間違っています。</div>
                    
                    <div class="mail">
                        <label>メールアドレス</label><br>
                        <input type="text" class="formbox" size="40" name="mail">
                    </div>
                    
                    <div class="password">
                        <label>パスワード</label><br>
                        <input type="password" class="formbox" size="40" name="password">
                    </div>
                    
                    <div class="login_check">
                        <label><input type="checkbox" class="formbox" size="40" name="login_keep" value="login_keep">ログイン状態を保持する</label>
                    </div>
                    
                    <div class="Button">
                        <input type="submit" class="SubmitButton" size="40" value="ログイン">
                    </div>
                </div>
            </form>
        </main>
        
        <footer>
            ©️2018 InterNous.inc.All rights reserved
        </footer>
    </body>
</html>