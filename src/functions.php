<?php
// template/admin/adduser.php及び 
// template/admin/edituser.php内で使用 
  // postで受け取ったデータがあるなら返す
  function getValue($name){
    $res = "";
    if(isset($_POST['employee_id'])){
      $res = $_POST[$name];
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