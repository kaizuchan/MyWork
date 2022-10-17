<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        勤務表
    </title>
    <?= $this->Html->css("User_table") ?>
    <!-- 戻るアイコンボタン -->
    <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/header'); ?>
</head>
<body>
    
    <div><button id="backButton"><i class="fas fa-arrow-circle-left fa-3x"></i></button></div>

    <div class="id_name">
        <h6>ID:123456</h6>
        <h6>横田守生</h6>
    </div>
        <h1 class="title">勤務時間表</h1>
        <h2 class="oct">10月</h2>
    <div class="month">
        <h3>前の月へ</h3>
        <h3>次の月へ</h3>
    </div>

    <div class="total">
        <table>
                <th>総労働時間</th>
                <td>152時間</td>
        </table>
        <table>
                <th>総残業時間</th>
                <td>９時間</td>
        </table>
        <table>
                <th>総勤務時間</th>
                <td>161時間</td>
        </table>
        <table>
                <th>出勤日数</th>
                <td>19日</td>
        </table>
    </div>

    <table class="glaf">
        <thead>
            <tr>
                <td class="non"></td>
                <th class="fir_row"scope="col">出勤時間</th>
                <th class="fir_row"scope="col">退勤時間</th>
                <th class="fir_row"scope="col">休憩開始時間</th>
                <th class="fir_row"scope="col">休憩終了時間</th>
                <th class="fir_row"scope="col">労働時間</th>
                <th class="fir_row"scope="col">休憩時間</th>
                <th class="fir_row"scope="col">残業時間</th>
                <th class="fir_row"scope="col">総勤務時間</th>
            </tr>
        </thead>
        <tbody><? for($i=1; $i<=31; $i++){
                   echo "
                
                        "; }
                ?>
            <tr>
                <th class="date">1日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
                
            </tr>
            <tr>
                <th class="date">2日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">3日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">4日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">5日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">6日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">7日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">8日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">9日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            <tr>
                <th class="date">10日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">11日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">12日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">13日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">14日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">15日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">16日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">17日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">18日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">19日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">20日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">21日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">22日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">23日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">24日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">25日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">26日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">27日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">28日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">29日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">30日</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">-</td>
                <td data-label="休憩時間" class="time">-</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">-</td>
            </tr>
            <tr>
                <th class="date">31日</th>
                <td data-label="出勤時間" class="time">09:00</td>
                <td data-label="退勤時間" class="time">18:00</td>
                <td data-label="休憩開始時間" class="time">12:00</td>
                <td data-label="休憩終了時間" class="time">13:00</td>
                <td data-label="労働時間" class="time">8</td>
                <td data-label="休憩時間" class="time">1</td>
                <td data-label="残業時間" class="time">-</td>
                <td data-label="総労働時間" class="time">8</td>
            </tr>
            <tr>
                <th class="date">合計</th>
                <td data-label="出勤時間" class="time">-</td>
                <td data-label="退勤時間" class="time">-</td>
                <td data-label="休憩開始時間" class="time">-</td>
                <td data-label="休憩終了時間" class="time">-</td>
                <td data-label="労働時間" class="time">152時間</td>
                <td data-label="休憩時間" class="time">9時間</td>
                <td data-label="残業時間" class="time">161時間</td>
                <td data-label="総労働時間" class="time">19時間</td>
            </tr>
        </tbody>
    </table>   

</body>



</html>