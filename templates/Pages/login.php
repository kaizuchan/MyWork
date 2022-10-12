<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <?php echo $this->Html->css("login");?>
</head>
<body>
    <h1>ログイン</h1>
    <form id="loginForm">
      <div class="mb-3">
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="企業ID">
      </div>
      <div class="mb-3">
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="社員ID">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワード">
      </div>
      <button type="submit" class="btn btn-primary">ログイン</button>
    </form>
</body>
</html>