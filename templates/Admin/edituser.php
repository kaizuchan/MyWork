<?php
// 更新失敗した場合に入力された値を保持させる
if ($this->request->is('post')) {
  $user = [];
  $data = $this->request->getData();
  $data['role'] = '';
  foreach($data as $k => $d){
      $user = array_merge($user, [$k => $d]);
  }
  $this->set(compact('user'));
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>社員編集</title>
  <?php echo $this->Html->css("addUser"); ?>
    <!-- 戻るアイコンボタン　コンポーネントリンク -->
  <?php echo $this->Html->css("backButton"); ?>
    <!-- モーダルウィンドウ -->
    <?php echo $this->Html->css("modal"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/headerAdmin'); ?>
    <!-- エラーメッセージや成功メッセージ -->
    <?php echo $this->Html->css("message"); ?>

    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

</head>
<body>
  
  <div id="toast">
    <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->
  </div>

<div id="main">
    <div class="Card">
      <!-- 戻るボタン -->
      <div id="backButtonBox"><button id="open" id="backButton"><i class="fas fa-angle-double-left"></i></button></div>
      <h1 class="title">社員編集</h1>
      

      <form class="was-validated h-adr" method="POST">
      <input type="hidden" class="p-country-name" value="Japan">

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">社員ID</span>
          <input name="employee_id" value="<?= $user['employee_id'] ?>" type="text" id="validationTextarea" class="form-control" placeholder="数字のみ" aria-label="社員ID" aria-describedby="basic-addon1" pattern="^[0-9]+$" required>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">姓</span>
          <input name="last_name" value="<?= $user['last_name'] ?>" type="text" class="form-control" placeholder="山田" aria-label="姓" pattern=".*\S+.*" required>
          <span class="input-group-text">名</span>
          <input name="first_name" value="<?= $user['first_name'] ?>" type="text" class="form-control" placeholder="太郎" aria-label="名" pattern=".*\S+.*" required>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">セイ</span>
          <input name="last_name_kana" value="<?= $user['last_name_kana'] ?>" type="text" class="form-control" placeholder="ヤマダ" aria-label="セイ" pattern="[\u30A1-\u30FC]*" required>
          <span class="input-group-text">メイ</span>
          <input name="first_name_kana" value="<?= $user['first_name_kana'] ?>" type="text" class="form-control" placeholder="タロウ" aria-label="メイ" pattern="[\u30A1-\u30FC]*" required>
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">電話番号</span>
          <input name="phone_number" value="<?= $user['phone_number'] ?>" type="text" id="validationTextarea" class="form-control" placeholder="ハイフン(-)なし" aria-label="電話番号" aria-describedby="basic-addon1" pattern="^0\d{9,10}$" required>
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">メールアドレス</span>
          <input name="email" value="<?= $user['email'] ?>" type="email" id="validationTextarea" class="form-control" placeholder="例）hal.nagoya@gmail.com" aria-label="メールアドレス" aria-describedby="basic-addon1" required>
        </div>

        <h2 class="itemsTitle">性別</h2>

        <div class="form-check-group">
          <div class="form-check">
            <input name="gender" value="0" type="radio" class="form-check-input"  id="validationFormCheck2" name="radio-stacked" required<?= setCheckdGender(0, $user['gender']); ?>>
            <label for="validationFormCheck2" class="form-check-label">男性</label>
          </div>
          <div class="form-check mb-3 woman-radioButton">
            <input name="gender" value="1" type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked"<?= setCheckdGender(1, $user['gender']); ?>>
            <label for="validationFormCheck3" class="form-check-label">女性</label>
          </div>
        </div>

        
        <h2 class="itemsTitle">生年月日</h2>
        <div class="input-group birth-select mb-3">
          <select name="birthday-year" class="form-select" id="inputGroupSelect01" aria-label="年">
            <?php echo setNumberOptions(1920, date('Y'), date('Y', strtotime($user["birthday"]))); ?>
            </select>
          <label class="input-group-text" for="inputGroupSelect01">年</label>
          <select name="birthday-month"  class="form-select" aria-label="月">
            <?php echo setNumberOptions(1, 12, date('m', strtotime($user["birthday"]))); ?>
          </select>
          <label class="input-group-text" for="inputGroupSelect01">月</label>
            <select name="birthday-date" class="form-select" aria-label="日">
              <?php echo setNumberOptions(1, 31, date('d', strtotime($user["birthday"]))); ?>
            </select>
          <label class="input-group-text" for="inputGroupSelect01">日</label>
        </div>

        
        <h2 class="itemsTitle">住所</h2>
        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">郵便番号</span>
          <input name="postalcode" value="<?= $user['postalcode'] ?>" type="text" id="validationTextarea" class="form-control p-postal-code" placeholder="ハイフン(-)なし" aria-label="郵便番号" aria-describedby="basic-addon1"  pattern="^\d{7}$" required>
        </div>

        <div class="input-group mb-3">
          <label class="input-group-text" for="inputGroupSelect01">都道府県</label>
          <select name="prefecture_id" class="form-select p-region-id" id="inputGroupSelect01" aria-label="都道府県" required>
            <?php echo setPrefectureOptions($user['prefecture_id']); ?>
          </select>
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">市区町村</span>
          <input name="city" value="<?= $user['city'] ?>" type="text" id="validationTextarea" class="form-control p-locality p-street-address" placeholder="例）名古屋市東区東桜" aria-label="市区町村" aria-describedby="basic-addon1"  pattern=".*\S+.*" required>
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">番地</span>
          <input name="block" value="<?= $user['block'] ?>" type="text" id="validationTextarea" class="form-control" placeholder="例）1丁目9-26" aria-label="番地" aria-describedby="basic-addon1"  pattern=".*\S+.*" required>
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">建物名・部屋番号</span>
          <input name="building" value="<?= $user['building'] ?>" type="text" id="validationTextarea" class="form-control" placeholder="例）IKKOパーク栄ビル3階階" aria-label="建物名・部屋番号" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">パスワード</span>
          <input name="new_password" type="password" id="userpass" class="form-control" placeholder="パスワードが未入力の場合変更されません" aria-label="パスワード" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" oninput="CheckPassword()">

        </div>
        <div class="inputMessage"><p>半角英大文字、半角英小文字、半角数字を必ず含み、8文字以上（その他は文字含ませない）</p></div>
        <div id="passwordCheck">
          <input type="checkbox" id="passCheck">パスワードを表示
        </div>
        
        <div class="input-group mb-3 ">
          <span class="input-group-text" id="basic-addon1">パスワード(確認)</span>
          <input type="password" id="password_confirm" class="form-control" placeholder="パスワードが未入力の場合変更されません" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" oninput="CheckPassword()">

        </div>
        <div class="inputMessage"><p>半角英大文字、半角英小文字、半角数字を必ず含み、8文字以上（その他は文字含ませない）</p></div>
        <div id="passwordCheck">
          <input type="checkbox" id="passconfCheck">パスワードを表示
        </div>

        <input
                type="hidden" name="_csrfToken" autocomplete="off"
                value="<?= $this->request->getAttribute('csrfToken') ?>">
        <input type="hidden" name="enterprise_id" value="<?= $me->enterprise_id ?>">

          <div class="form-check" id="checkBox">
            <input name="role" value="2" type="checkbox" class="form-check-input" id="validationFormCheck4" name="radio-stacked"<?= setCheckdAdmin($user['role']); ?>>
            <label for="validationFormCheck4" class="form-check-label">管理者として登録する場合はチェック</label>
          </div>

          <div class="d-grid gap-2">
            <button class="btn" type="submit">変更</button>
          </div>
        </div>
      </div>
  </form> 
  <div id="mask" class="hidden"></div>
  <section id="modal" class="hidden">
      <p id="editMessage">編集が完了してません。<br>終了してよろしいですか？</p>
      <div  id="selectButton">
          <div id="yesClose">
          <a href="/admin/"><button id="yesButton">はい</button></a>
          </div>
          <div id="noClose">
              <button id="noButton">いいえ</button>
          </div>
      </div>
  </section>
  <script>
    function CheckPassword() {
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
  <?php echo $this->Html->script("admin"); ?>
  <?php echo $this->Html->script("modal"); ?>
  <?php echo $this->Html->script("toast"); ?>
</body>
</html>