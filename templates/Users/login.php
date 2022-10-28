<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <?php echo $this->Html->css("login");?>
    <?php echo $this->Html->css("modal");?>
</head>
<body>
    
    
    
    <div class="back">
    </div>

      <div class="card" id="loginCard">
        <h1>
        <div id="logo">
          MyWork
        </h1>
        <div class="card-body">
          <form id="loginForm" method="POST" action="/users">
            <div class="mb-3">
              <input name="enterprise_id" type="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="企業ID" required>
            </div>
            <div class="mb-3">
              <input name="employee_id" type="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="社員ID" required>
            </div>
            <div class="mb-3">
              <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワード" required>
            </div>
            <input
                  type="hidden" name="_csrfToken" autocomplete="off"
                  value="<?= $this->request->getAttribute('csrfToken') ?>">
            <!-- <input type="hidden" name="id" value="87"> -->
            <button type="submit">ログイン</button>
          </form>        
          <div id="toast">
            <?= $this->Flash->render() ?>
          </div>
        </div>

      </div>
      <?php echo $this->Html->script("toast"); ?>
      <?php echo $this->Html->script("admin"); ?>
</body>
</html>