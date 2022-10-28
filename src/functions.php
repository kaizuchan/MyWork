<?php
/* 入力フォームの初期値設定
  * 使用場所
  * template/admin/adduser.php
  * template/admin/edituser.php
 */
  // postで受け取ったデータがあるなら返す
  function setValue($name, $use_cookie = false){
    $res = "";
    if(isset($_POST[$name])){
      $res = $_POST[$name];
    }else if(isset($_COOKIE[$name]) && $use_cookie){
      $res = $_COOKIE[$name];
    }
    //echo $res;
    return $res;
  }
  // 都道府県 セレクトボックス option生成
  function setPrefectureOptions($default = null){
    $prefectures = array(
      1  => '北海道',2  => '青森県',3  => '岩手県',4  => '宮城県',5  => '秋田県',
      6  => '山形県',7  => '福島県',8  => '茨城県',9  => '栃木県',10 => '群馬県',
      11 => '埼玉県',12 => '千葉県',13 => '東京都',14 => '神奈川県',15 => '新潟県',
      16 => '富山県',17 => '石川県',18 => '福井県',19 => '山梨県',20 => '長野県',
      21 => '岐阜県',22 => '静岡県',23 => '愛知県',24 => '三重県',25 => '滋賀県',
      26 => '京都府',27 => '大阪府',28 => '兵庫県',29 => '奈良県',30 => '愛媛県',
      31 => '和歌山県',32 => '鳥取県',33 => '島根県',34 => '岡山県',35 => '広島県',
      36 => '山口県',37 => '徳島県',38 => '香川県',39 => '高知県',40 => '福岡県',
      41 => '佐賀県',42 => '長崎県',43 => '熊本県',44 => '大分県',45 => '宮崎県',
      46 => '鹿児島県',47 => '沖縄県',
    );
    $res = "";
    if($default == null){
      $res .= '<option value="" selected hidden>選択してください</option>';
    }
    foreach($prefectures as $k => $p){
      if($default == $k){
          $res .= '<option value="'.$k.'" selected>'.$p.'</option>';
      }else{
          $res .= '<option value="'.$k.'">'.$p.'</option>';
      }
    }
    return $res;
  }
  // 都道府県 セレクトボックス option生成
  function setIdentifyOptions($default = null){
    $prefectures = array(
      1 => '出勤時間',
      2 => '休憩開始時間',
      3 => '休憩終了時間',
      4 => '退勤時間',
    );
    $res = "";
    if($default == null){
      $res .= '<option value="" selected hidden>選択してください</option>';
    }
    foreach($prefectures as $k => $p){
      if($default == $k){
          $res .= '<option value="'.$k.'" selected>'.$p.'</option>';
      }else{
          $res .= '<option value="'.$k.'">'.$p.'</option>';
      }
    }
    return $res;
  }
  // 数値 セレクトボックス option生成
  function setNumberOptions($min, $max, $default = null){
    $res = '';
    if($default == null){
      $res .= '<option value="" selected hidden>選択してください</option>';
    }
    for ($i = $min; $i <= $max; $i++) {
      if($default == $i){
        $res .= '<option value="'.$i.'" selected>'.$i.'</option>';
      }else{
        $res .= '<option value="'.$i.'">'.$i.'</option>';
      }
    }
    return $res;
  }
  // 性別ラジオボタン 初期値追加
  function setCheckdGender($value, $default){
    if($value == $default){
      echo ' checked="checked"';
    }
  }
  // 管理者 チェックボックス 初期値
  function setCheckdAdmin($default = null){
    if($default == 2){
      echo ' checked="checked"';
    }
  }

  /* 勤怠履歴 表示
   * 使用場所
   * template/Home/works.php
  */
  function setTime($data)
  {
    $i = 0;
    foreach($data as $d){
      if($i != 0){
        echo '<br>';
      }
      echo date('H:i', strtotime($d));
      $i++;
    }
    if($i == 0){
      echo '-';
    }
  }

  /* 勤怠編集ページ */
  //打刻種別 表示
  function setText($identify){
    switch($identify){
      case 1:
        echo "出勤時間";
        break;
      case 2:
        echo "休憩開始時間";
        break;
      case 3:
        echo "休憩終了時間";
        break;
      case 4:
        echo "退勤時間";
        break;
    }
  }
  function setDateSelected($date, $time){
    if($date->i18nFormat('yyyy-MM-dd') != $time->i18nFormat('yyyy-MM-dd')){
      echo ' selected';
    }
  }

  /* 勤怠履歴 労働時間	休憩時間	残業時間	総勤務時間 小数点表示 
   * 使用場所
   * templates/Admin/works.php
   * templates/Home/works.php
  */
  function echoFloat($data){
    if(gettype($data) == "double"){
      echo number_format($data, 1);
    }else{
      echo $data;
    }
  }

    /* 「編集/打刻」表示用
   * 使用場所
   * templates/Admin/works.php
   * templates/Admin/editworks.php
   * templates/Home/works.php
  */
  function echoPunchedStatement($info, $start_work = 'non_null'){
    if($start_work != null){
      if($info == 1){
        echo '打刻';
      }else if($info == 2){
        echo '編集';
      }
    }else{
      echo'-';
    }
  }