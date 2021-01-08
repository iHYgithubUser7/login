<?php
mb_internal_encoding("utf8");
session_start();

if(empty($_SESSION['id'])){
    
    //try catch文。DBに接続出来なければエラーメッセージを表示
    try{
        $pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","root");
    }catch(PDOException $e){
        die("<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセスが出来ません。<br>しばらくしてから再度ログインをしてください。</p>
        <a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>");
    }
    
    //prepared statementでSQL文の型を作る
    //DBとpostデータを照合させる。select文とwhere句を使用
    $stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?");
    
    //bindValueメソッドでパラメータをセット
    $stmt->bindValue(1,$_POST['mail']);
    $stmt->bindValue(2,$_POST['password']);
    
    //executeでクエリを実行
    $stmt->execute();
    //データベースを切断
    $pdo = NULL;
    
    
    //fetch・while文でデータ取得し、sessionに代入
    while($row = $stmt->fetch()){
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['mail'] = $row['mail'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['picture'] = $row['picture'];
        $_SESSION['comments'] = $row['comments'];
    }
    
    
    //データ取得が出来ずに(emptyを使用して判定)sessionがなければ、リダイレクト(エラー画面へ)
    if(empty($_SESSION['id'])){
        header("Location:login_error.php");
    }
    
    //「ログイン状態を保持する」にチェックが入っていた場合、postされたlogin_keepの値をsessionに保存する
    if(!empty($_POST['login_keep'])){
        $_SESSION['login_keep']=$_POST['login_keep'];
    }
}

//ログインに成功かつ$_SESSION[login_keep]が空でない場合(チェックを入れている場合)cookieにデータを保存
//time()+60*60*24*7 ：現在から7日間有効
//$_SESSION[login_keep]が空の場合はcookieのデータを削除
//time()-1 ：過去の時間を指定することでデータを削除
if(!empty($_SESSION['id']) && !empty($_SESSION['login_keep'])){
    setcookie('mail', $_SESSION['mail'], time()+60*60*24*7);
    setcookie('password', $_SESSION['password'], time()+60*60*24*7);
    setcookie('login_keep', $_SESSION['login_keep'], time()+60*60*24*7);
}else if(empty($_SESSION['login_keep'])){
    setcookie('mail', '', time()-1);
    setcookie('password', '', time()-1);
    setcookie('login_keep', '', time()-1);
}
?>


<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>マイページ登録</title>
        <link rel="stylesheet" type="text/css" href="mypage.css">
    </head>
    
    <body>
        <!-- マイページとして表示する部分の記述 + 代入したsessionを記述 -->
        <!-- http://localhost/login_mypage/mypage.php -->
        
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="logout"><a href="log_out.php">ログアウト</a></div>
        </header>
        
        <main>
            <div class="MypageInfo">
                <h2>会員情報</h2>
                <div class="hello">
                    <?php echo "こんにちは！".$_SESSION['name']."さん"; ?>
                </div>
                
                <div class="profile_pic">
                    <img src="<?php echo $_SESSION['picture']; ?>">
                </div>
                
                <div class="BasicInfo">
                    <p>氏名：<?php echo $_SESSION['name']; ?></p>
                    <p>メール：<?php echo $_SESSION['mail']; ?></p>
                    <p>パスワード：<?php echo $_SESSION['password']; ?></p>
                </div>
                
                <div class="comments">
                    <?php echo $_SESSION['comments']; ?>
                </div>
                
                <form action="mypage_hensyu.php" method="post">
                    <input type="hidden" value="<?php echo rand(1,10);?>" name="from_mypage">
                    <div class="Button">
                        <input type="submit" class="EditButton" size="35" value="編集する">
                    </div>
                </form>
            </div>
        </main>
    </body>
    
    <footer>
        ©️2018 InterNous.inc.All rights reserved
    </footer>
</html>