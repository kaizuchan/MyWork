<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤務履歴表編集画面</title>
    <?php echo $this->Html->css("myWorkEdit"); ?>
    <!-- 戻るアイコンボタン -->
    <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/headerAdmin'); ?>
    <!-- モーダルウィンドウ -->
    <?php echo $this->Html->css("modal"); ?>
    <!-- エラーメッセージや成功メッセージ -->
    <?php echo $this->Html->css("message"); ?>
</head>
<body>
    <div>
        <div id="toast">
            <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->
        </div>

        <div id="main">
            <div class="Card">
                <!-- 戻るボタン -->
                <div id="backButtonBox">
                <a href="/admin/works/<?= $user->id ?>"><button><i class="fas fa-angle-double-left"></i></button></a></div>

                <div class="id_name">
                    <p>ID:<?= $user->employee_id ?></p>
                    <p><?= $user->last_name.$user->first_name ?></p>
                </div>
                <div><h1 class="title">勤務表履歴</h1></div>

                <?php 
                    $year = (int) substr($date, 0, 4); 
                    $month = (int) substr($date, 4, 2); 
                    $date = (int) substr($date, 6, 2); 
                ?>
                    <h2 class="oct"><?= $year ?>年 <?= $month ?>月<?= $date ?>日</h2>

                <div id="addPunch">
                    <button  class="btn btn-outline-info" onclick="addRecord()">打刻追加<i class="far fa-hourglass"></i></button>
                </div>

                <div class="scroll_bar">
                    <div id="editTable">
                        <table class="table">
                        
                            <thead  class="table-light">
                                <tr>
                                    <th>打刻種別</th>
                                    <th>打刻日付</th>
                                    <th>打刻時間</th>
                                    <th>保存</th>
                                    <th>削除</th>
                                    <th>打刻方法</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- レコード挿入部分 -->
                                <div>
                                    <form method="post">
                                        <tr id="addRecord" class="hidden">
                                            <td>
                                                <select name="identify" class="form-select" required>
                                                    <?= setIdentifyOptions() ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input name="date" type="date" value="" required>
                                            </td>
                                            <td><input name="time" type="time" value="" required></td>
                                            <td class="edit"><button name="insert" class="btn btn-outline-info" type="submit">追加</button></td>
                                            <td class="edit"><button name="delete" class="btn btn-outline-danger" type="button" onclick="removeRecord()">削除</button></td>
                                            <td>編集</td>
                                        </tr>
                                        <input
                                            type="hidden" name="_csrfToken" autocomplete="off"
                                            value="<?= $this->request->getAttribute('csrfToken') ?>">
                                    </form>
                                </div>
                                <?php foreach($times as $time): ?>
                                    <form method="post">
                                        <tr>
                                            <td>
                                                <select name="identify" class="form-select" required>
                                                    <?= setIdentifyOptions($time->identify) ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input name="date" type="date" value="<?= $time->time->i18nFormat('YYYY-MM-dd') ?>" required>
                                            </td>
                                            <td><input name="time" type="time" value="<?= $time->time->i18nFormat('HH:mm') ?>" required></td>
                                            <td class="edit"><button name="update" class="btn btn-outline-info" type="submit">保存</button></td>
                                            <td class="edit"><button name="delete" class="btn btn-outline-danger" type="submit">削除</button></td>
                                            <td><?= echoPunchedStatement($time->info) ?></td>
                                        </tr>
                                        <input
                                            type="hidden" name="_csrfToken" autocomplete="off"
                                            value="<?= $this->request->getAttribute('csrfToken') ?>">
                                        <input type="hidden" name="id" value="<?= $time->id ?>">
                                        <input type="hidden" name="old_identify" value="<?= $time->identify ?>">
                                    </form>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo $this->Html->script("modal"); ?>
            <?php echo $this->Html->script("toast"); ?>
            <?php echo $this->Html->script("admin"); ?>
        </div>
    </div>
        
</body>
</html>