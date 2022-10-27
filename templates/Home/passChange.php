<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    </title>
    <?php echo $this->Html->css("passChange"); ?>
        <!-- 戻るアイコンボタン　コンポーネントリンク -->
    <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/header'); ?>
    <!-- エラーメッセージや成功メッセージ -->
    <?php echo $this->Html->css("message"); ?>
    <script>
        function CheckPassword(password_confirm) {
            // 入力値取得
            var input1 = userpass.value;
            var input2 = password_confirm.value;
            // パスワード比較
            if (input1 != input2) {
                password_confirm.setCustomValidity("入力値が一致しません。");
            } else {
                password_confirm.setCustomValidity('');
            }
        }
    </script>
</head>

<body>

    <div id="toast">
        <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->
    </div>
    
    <div id="main">
        <div class="Card">
            <a href="/">
                <div id="backButtonBox"><a href="/" id="backButton"><i class="fas fa-angle-double-left"></i></a></div>
            </a>

            <h1>パスワード変更</h1>

                <form class="was-validated h-adr" method="POST">

                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">現在のパスワード</span>
                      <input name="password" type="password" id="olduserpass" class="form-control" placeholder="" aria-label="パスワード" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required>
                    </div>
                    <div><p>半角英大文字、半角英小文字、半角数字を必ず含み、8文字以上（その他は文字含ませない）</p></div>
                    <div id="passwordCheck">
                      <input type="checkbox" id="oldPassCheck">現在のパスワードを表示
                    </div>

                    <div class="input-group mb-3 ">
                      <span class="input-group-text" id="basic-addon1">新しいパスワード</span>
                      <input name="password" type="password" id="userpass" class="form-control" placeholder="" aria-label="パスワード" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required>
                    </div>
                    <div><p>半角英大文字、半角英小文字、半角数字を必ず含み、8文字以上（その他は文字含ませない）</p></div>
                    <div id="passwordCheck">
                      <input type="checkbox" id="passCheck">新しいパスワードを表示
                    </div>
                    
                    <div class="input-group mb-3 ">
                      <span class="input-group-text" id="basic-addon1">新しいパスワード(確認)</span>
                      <input type="password" id="password_confirm" class="form-control" placeholder="" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required oninput="CheckPassword(this)">
                    </div>
                    <div><p>半角英大文字、半角英小文字、半角数字を必ず含み、8文字以上（その他は文字含ませない）</p></div>
                    <div id="passwordCheck">
                      <input type="checkbox" id="passconfCheck">新しいパスワードを表示
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn" type="submit">登録</button>
                    </div>
                </form>       
            </div> 
        </div>
    

    <?php echo $this->Html->script("modal"); ?>
    <?php echo $this->Html->script("admin"); ?>
</body>
</html>