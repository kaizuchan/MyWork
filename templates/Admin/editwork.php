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

        <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->

        <div id="main">
            <div class="Card">
                <!-- 戻るボタン -->
                <div id="backButtonBox"><a href="/admin/works/<?= $user->id ?>" id="backButton"><i class="fas fa-angle-double-left"></i></a></div>

                <div class="id_name">
                    <p>ID:<?= $user->employee_id ?></p>
                    <p><?= $user->last_name.$user->first_name ?></p>
                </div>

                <div><h1 class="title">勤務表履歴</h1></div>
                <?php 
                    $month = (int) substr($date, 4, 2); 
                    $date = (int) substr($date, 6, 2); 
                ?>
                    <h2 class="oct"><?= $month ?>月<?= $date ?>日</h2>

                <div class="scroll_bar">
                    <div id="editTable">
                        <table class="table">
                        <div>
                            <button  onclick="addRecord()">社員追加</button>
                        </div>
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
                                <?php foreach($times as $time): ?>
                                    <form method="post">
                                        <tr>
                                            <td><?= setText($time->identify) ?></td>
                                            <td>
                                                <input name="date" type="date" value="<?= $time->time->i18nFormat('Y-M-d') ?>">
                                            </td>
                                            <td><input name="time" type="time" value="<?= $time->time->i18nFormat('HH:mm') ?>" ></td>
                                            <td class="edit"><button name="update" class="btn btn-outline-info" type="submit">保存</button></td>
                                            <td class="edit"><button name="delete" class="btn btn-outline-danger" type="submit">削除</button></td>
                                            <td><?= echoPunchedStatement($time->info) ?></td>
                                        </tr>
                                        <input
                                            type="hidden" name="_csrfToken" autocomplete="off"
                                            value="<?= $this->request->getAttribute('csrfToken') ?>">
                                        <input type="hidden" name="id" value="<?= $time->id ?>">
                                        <input type="hidden" name="identify" value="<?= $time->identify ?>">
                                    </form>
                                <?php endforeach; ?>
                                <!-- レコード挿入部分 -->
                                <div>
                                    <form method="post">
                                        <tr id="addRecord" class="hidden">
                                            <td><?= setText($time->identify) ?></td>
                                            <td>
                                                <input name="date" type="date" value="">
                                            </td>
                                            <td><input name="time" type="time" value="" ></td>
                                            <td class="edit"><button name="update" class="btn btn-outline-info" type="submit">保存</button></td>
                                            <td class="edit"><button name="delete" class="btn btn-outline-danger" type="submit">削除</button></td>
                                            <td><?= echoPunchedStatement($time->info) ?></td>
                                        </tr>
                                        <input
                                            type="hidden" name="_csrfToken" autocomplete="off"
                                            value="<?= $this->request->getAttribute('csrfToken') ?>">
                                        <input type="hidden" name="id" value="">
                                        <input type="hidden" name="identify" value="">
                                    </form>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>


                        
                        <div id="mask" class="hidden"></div>
                        <section id="modal" class="hidden">
                            <p id="editMessage">編集が完了してません。<br>終了してよろしいですか？</p>
                            <div  id="selectButton">
                                <div id="yesClose">
                                    <button id="yesButton">はい</button>
                                </div>
                                <div id="noClose">
                                    <button id="noButton">いいえ</button>
                                </div>
                            </div>
                        </section>
                    

                </div>
                <?php echo $this->Html->script("modal"); ?>
                <?php echo $this->Html->script("admin"); ?>
            </div>
        </div>
        
</body>
</html>