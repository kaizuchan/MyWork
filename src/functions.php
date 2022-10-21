<?php
/* 入力フォームの初期値設定
  * 使用場所
  * template/admin/adduser.php
  * template/admin/edituser.php
 */
  // postで受け取ったデータがあるなら返す
  function setValue($name){
    $res = "";
    if(isset($_POST[$name])){
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
  // 管理者 チェックボックス 初期値
  function setCheckdAdmin($default = null){
    if($default == 2){
      echo ' checked="checked"';
    }
  }

  
/* 仕事時間計算
  * 使用場所
  * src\Controller\HomeController.php
 */
  // 計算結果を配列に格納して返す
  function calculateHours($data){
    // 総勤務時間 計算
    if(strtotime($data['end_work']) > strtotime($data['start_work'])){
      $total = ((strtotime($data['end_work']) - strtotime($data['start_work'])) / 3600);
      $total = round($total, 1, PHP_ROUND_HALF_DOWN);
    }else{
      $total = ((strtotime($data['end_work']) + 86400 - strtotime($data['start_work'])) / 3600);
      $total = round($total, 1, PHP_ROUND_HALF_DOWN);
    }
    // 休憩時間 計算
    if(strtotime($data['end_work']) > strtotime($data['start_work'])){
      $break = ((strtotime($data['end_break']) - strtotime($data['start_break'])) / 3600);
      $break = round($break, 1, PHP_ROUND_HALF_DOWN);
    }else{
      $break = ((strtotime($data['end_break']) + 86400 - strtotime($data['start_break'])) / 3600);
      $break = round($break, 1, PHP_ROUND_HALF_DOWN);
    }
    // 勤務時間 & 残業時間 計算
    $overtime = 0;
    $work = $total;
    if($work > 8){
      $overtime = $work - 8;
      $work = 8;
    }
    // 計算結果を配列に格納して返却
    if($total == 0){
      return array_merge($data, array(
        'work' => '-',
        'break' => '-',
        'overtime' => '-',
        'total' => '-',
      ));
    }else{
      return array_merge($data, array(
        'work' => $work,
        'break' => $break,
        'overtime' => $overtime,
        'total' => $total,
      ));
    }
  }
  // 月ごとの総労働時間、労働時間、残業時間、出勤日数の計算
  function calculateMonthlyHours($data){
    $work = 0;
    $total = 0;
    $overtime = 0;
    $workday = 0;
    foreach($data['dates'] as $date){
      if($date['end_work'] != null){
        $work += (int) $date['work'];
        $total += (int) $date['total'];
        $overtime += (int) $date['overtime'];
        $workday += 1;
      }
    }
    return array_merge($data, [
      'work' => $work,
      'total' => $total,
      'overtime' => $overtime,
      'workday' => $workday,
    ]);
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
      echo $d;
      $i++;
    }
  }