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
        <tbody>
            <?php for($i=1; $i<=31; $i++){ ?>
            <tr>
                <th class="date"><?php echo $i; ?>日</th>
                <?php 
                    foreach($res as $r){
                        // debug($r->date);
                        if($r->identify == 1){

                            $time = $r->time;
                            debug($time);
                ?>
                <td data-label="出勤時間" class="shukkin"><?php echo $time; ?></td>
                    <?php } ?>
                <?php } ?>
                <td data-label="退勤時間" class="taikin">18:00</td>
                <td data-label="休憩開始時間" class="kyushi">12:00</td>
                <td data-label="休憩終了時間" class="kyukei">13:00</td>
                <td data-label="労働時間" class="roudou">8</td>
                <td data-label="休憩時間" class="kyukei">1</td>
                <td data-label="残業時間" class="zangyou">-</td>
                <td data-label="総労働時間" class="souroudou">8</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>   
</body>
</html>