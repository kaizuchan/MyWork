<?php
  function getValue($name){
    $res = "";
    if(isset($_POST['employee_id'])){
      $res = $_POST[$name];
    }
    echo $res;
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>社員登録</title>
  <?php echo $this->Html->css("addUser"); ?>
    <!-- 戻るアイコンボタン　コンポーネントリンク -->
  <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/headerAdmin'); ?>
    <!-- エラーメッセージや成功メッセージ -->
    <?php echo $this->Html->css("message"); ?>

    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
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
  
  <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->

  <h1>社員登録</h1>
  
  <!-- 戻るボタン -->
  <?php echo $this->element('components/backButton'); ?>

  <form class="was-validated h-adr" method="POST">
  <input type="hidden" class="p-country-name" value="Japan">

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">社員ID</span>
      <input name="employee_id" value="<?= getValue('employee_id') ?>" type="text" id="validationTextarea" class="form-control" placeholder="社員ID" aria-label="社員ID" aria-describedby="basic-addon1" required>
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text">姓</span>
      <input name="last_name" value="<?= getValue('last_name') ?>" type="text" class="form-control" placeholder="姓" aria-label="姓" required>
      <span class="input-group-text">名</span>
      <input name="first_name" value="<?= getValue('first_name') ?>" type="text" class="form-control" placeholder="名" aria-label="名" required>
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text">セイ</span>
      <input name="last_name_kana" value="<?= getValue('last_name_kana') ?>" type="text" class="form-control" placeholder="セイ" aria-label="セイ" pattern="[\u30A1-\u30F6]*" required>
      <span class="input-group-text">メイ</span>
      <input name="first_name_kana" value="<?= getValue('first_name_kana') ?>" type="text" class="form-control" placeholder="メイ" aria-label="メイ" pattern="[\u30A1-\u30F6]*" required>
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">電話番号</span>
      <input name="phone_number" value="<?= getValue('phone_number') ?>" type="text" id="validationTextarea" class="form-control" placeholder="電話番号" aria-label="電話番号" aria-describedby="basic-addon1" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" required>
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">メールアドレス</span>
      <input name="email" value="<?= getValue('email') ?>" type="email" id="validationTextarea" class="form-control" placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="basic-addon1" required>
    </div>

    <h2>性別</h2>

    <div class="form-check-group">
      <div class="form-check">
        <input name="gender" value="0" type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" required>
        <label for="validationFormCheck2" class="form-check-label">男性</label>
      </div>
      <div class="form-check woman-radioButton">
        <input name="gender" value="1" type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked">
        <label for="validationFormCheck3" class="form-check-label">女性</label>
      </div>
    </div>

    
    <h2>生年月日</h2>
    <div class="input-group birth-select mb-3">
      <select name="birthday-year" class="form-select" id="inputGroupSelect01" aria-label="年" required>
          <option value=""></option>
          <?php
          for ($i = 1920; $i <= 2022; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
          }
          ?>
        </select>
      <label class="input-group-text" for="inputGroupSelect01">年</label>
      <select name="birthday-month"  class="form-select" aria-label="月" required>
          <option value=""></option>
          <?php
          for ($i = 1; $i <= 12; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
          }
          ?>
        </select>
      <label class="input-group-text" for="inputGroupSelect01">月</label>
        <select name="birthday-date" class="form-select" aria-label="日" required>
          <option value=""></option>
          <?php
          for ($i = 1; $i <= 31; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
          }
          ?>
        </select>
      <label class="input-group-text" for="inputGroupSelect01">日</label>
    </div>

    
    <h2>住所</h2>
    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">郵便番号</span>
      <input name="postalcode" value="<?= getValue('postalcode') ?>" type="text" id="validationTextarea" class="form-control p-postal-code" placeholder="xxx-xxxx" aria-label="郵便番号" aria-describedby="basic-addon1"  pattern="\d{3}-?\d{4}" required>
    </div>

    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01">都道府県</label>
      <select name="prefecture_id" class="form-select p-region" id="inputGroupSelect01" aria-label="都道府県" required>
        <option value=""></option>
        <option value="1">北海道</option>
        <option value="2">青森県</option>
        <option value="3">岩手県</option>
        <option value="4">宮城県</option>
        <option value="5">秋田県</option>
        <option value="6">山形県</option>
        <option value="7">福島県</option>
        <option value="8">茨城県</option>
        <option value="9">栃木県</option>
        <option value="10">群馬県</option>
        <option value="11">埼玉県</option>
        <option value="12">千葉県</option>
        <option value="13">東京都</option>
        <option value="14">神奈川県</option>
        <option value="15">新潟県</option>
        <option value="16">富山県</option>
        <option value="17">石川県</option>
        <option value="18">福井県</option>
        <option value="19">山梨県</option>
        <option value="20">長野県</option>
        <option value="21">岐阜県</option>
        <option value="22">静岡県</option>
        <option value="23">愛知県</option>
        <option value="24">三重県</option>
        <option value="25">滋賀県</option>
        <option value="26">京都府</option>
        <option value="27">大阪府</option>
        <option value="28">兵庫県</option>
        <option value="29">奈良県</option>
        <option value="30">和歌山県</option>
        <option value="31">鳥取県</option>
        <option value="32">島根県</option>
        <option value="33">岡山県</option>
        <option value="34">広島県</option>
        <option value="35">山口県</option>
        <option value="36">徳島県</option>
        <option value="37">香川県</option>
        <option value="38">愛媛県</option>
        <option value="39">高知県</option>
        <option value="40">福岡県</option>
        <option value="41">佐賀県</option>
        <option value="42">長崎県</option>
        <option value="43">熊本県</option>
        <option value="44">大分県</option>
        <option value="45">宮崎県</option>
        <option value="46">鹿児島県</option>
        <option value="47">沖縄県</option>
      </select>
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">市区町村</span>
      <input name="city" value="<?= getValue('city') ?>" type="text" id="validationTextarea" class="form-control p-locality p-street-address" placeholder="市区町村" aria-label="市区町村" aria-describedby="basic-addon1" required>
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">番地</span>
      <input name="block" value="<?= getValue('block') ?>" type="text" id="validationTextarea" class="form-control" placeholder="○丁目○番地" aria-label="番地" aria-describedby="basic-addon1" required>
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">建物名・部屋番号</span>
      <input name="building" value="<?= getValue('building') ?>" type="text" id="validationTextarea" class="form-control" placeholder="建物名・部屋番号" aria-label="建物名・部屋番号" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">パスワード</span>
      <input name="password" type="password" id="userpass" class="form-control" placeholder="パスワード" aria-label="パスワード" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required>
    </div>
    
    <div class="input-group mb-3 ">
      <span class="input-group-text" id="basic-addon1">パスワード(確認)</span>
      <input type="password" id="password_confirm" class="form-control" placeholder="パスワード" aria-describedby="basic-addon1" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required oninput="CheckPassword(this)">
    </div>

    <input
            type="hidden" name="_csrfToken" autocomplete="off"
            value="<?= $this->request->getAttribute('csrfToken') ?>">
    <input type="hidden" name="enterprise_id" value="<?= $me->enterprise_id ?>">

      <div class="form-check" id="checkBox">
        <input name="role" value="2" type="checkbox" class="form-check-input" id="validationFormCheck4" name="radio-stacked">
        <label for="validationFormCheck4" class="form-check-label">管理者として登録する場合はチェック</label>
      </div>

      <div class="d-grid gap-2">
        <button class="btn" type="submit">登録</button>
      </div>

  </form>
</body>
</html>