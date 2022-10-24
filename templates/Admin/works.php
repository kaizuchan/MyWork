<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        勤務表
    </title>
    <?= $this->Html->css("adm_table") ?>
    <!-- 戻るアイコンボタン -->
    <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/headerAdmin'); ?>
</head>
<body>
    <div id="main">
        <div class="Card">
        <!-- 戻るボタン -->
        <div id="backButtonBox"><a href="/admin" id="backButton"><i class="fas fa-angle-double-left"></i></a></div>
            <div class="id_name">
                <p>ID:<?= $user->employee_id ?></p>
                <p><?= $user->last_name.$user->first_name ?></p>
            </div>
                <h1 class="title">勤務時間表</h1>
                <h2 class="oct"><?= $dates['month'] ?>月</h2>
            <div class="month">
                <h3><a href="/admin/works/<?= $id ?>/<?php echo date('m/Y', mktime(0,0,0,$dates['month']-1,1,2022)); ?>"><i class="fas fa-reply"></i><div class="nextMonth">前の月へ</div></a></h3>
                <h3><a href="/admin/works/<?= $id ?>/<?php echo date('m/Y', mktime(0,0,0,$dates['month']+1,1,2022)); ?>"><div class="nextMonth">次の月へ</div><i class="fas fa-share"></i></a></h3>
            </div>

            <div class="total">
                <table>
                        <th>総労働時間</th>
                        <td><?= $dates['total'] ?>時間</td>
                </table>
                <table>
                        <th>総残業時間</th>
                        <td><?= $dates['overtime'] ?>時間</td>
                </table>
                <table>
                        <th>総勤務時間</th>
                        <td><?= $dates['work'] ?>時間</td>
                </table>
                <table>
                        <th>出勤日数</th>
                        <td><?= $dates['workday'] ?>日</td>
                </table>
            </div>

            <div class="scroll_bar">
                <table class="glaf table table-striped">
                    <thead>
                        <tr>
                            <th class="fir_row"scope="col">編集</th>
                            <th class="fir_row"scope="col">日付</th>
                            <th class="fir_row"scope="col">出勤時間</th>
                            <th class="fir_row"scope="col">退勤時間</th>
                            <th class="fir_row"scope="col">休憩開始時間</th>
                            <th class="fir_row"scope="col">休憩終了時間</th>
                            <th class="fir_row"scope="col">労働時間</th>
                            <th class="fir_row"scope="col">休憩時間</th>
                            <th class="fir_row"scope="col">残業時間</th>
                            <th class="fir_row"scope="col">総勤務時間</th>
                            <th class="fir_row"scope="col">打刻方法</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dates['dates'] as $date): ?>
                            <tr>
                                <?php $d = date('Ymd', mktime(0, 0, 0, $dates['month'], $date['date'], $dates['year'])); ?>
                                <td class="edit"><button onclick="location.href='/admin/works/<?= $id ?>/edit/<?= $d ?>'" class="btn btn-outline-info" type="button">編集</button></td>
                                <th class="date"><?= $date['date'] ?>日</th>
                                <td data-label="出勤時間" class="time"><?= setTime($date['start_work']) ?></td>
                                <td data-label="退勤時間" class="time"><?= setTime($date['end_work']) ?></td>
                                <td data-label="休憩開始時間" class="time"><?= setTime($date['start_break']) ?></td>
                                <td data-label="休憩終了時間" class="time"><?= setTime($date['end_break']) ?></td>
                                <td data-label="労働時間" class="time"><?= echoFloat($date['work']) ?></td>
                                <td data-label="休憩時間" class="time"><?= echoFloat($date['break']) ?></td>
                                <td data-label="残業時間" class="time"><?= echoFloat($date['overtime']) ?></td>
                                <td data-label="総労働時間" class="time"><?= echoFloat($date['total']) ?></td>
                                <td data-label="打刻方法" class="time"><?= echoPunchedStatement($date['info'], $date['start_work']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>