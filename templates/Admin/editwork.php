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
    <?php echo $this->element('components/header'); ?>
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
                <?php echo $this->element('components/backButton'); ?>

                <div class="id_name">
                    <p>ID:123456</p>
                    <p>横田守生</p>
                </div>

                <div><h1 class="title">勤務表履歴</h1></div>
                <?php 
                    $month = (int) substr($date, 4, 2); 
                    $date = (int) substr($date, 6, 2); 
                ?>
                    <h2 class="oct"><?= $month ?>月<?= $date ?>日</h2>

                    <form method="post">
                        <div id="editTable">
                            <table class="table">
                                <thead  class="table-light">
                                    <tr>
                                        <th>打刻種別</th>
                                        <th>打刻時間</th>
                                        <th>打刻時間</th>
                                        <th>保存</th>
                                        <th>削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>出勤時間</td>
                                        <td>
                                            <select>
                                                <option value="">当日</option>
                                                <option value="">翌日</option>
                                            </select>
                                        </td>
                                        <td><input name="start_work" type="time" value="<?= $times['start_work'] ?>" ></td>
                                        <td class="edit"><button class="btn btn-outline-info" type="button">保存</button></td>
                                        <td class="edit"><button class="btn btn-outline-danger" type="button">削除</button></td>
                                    </tr>
                                    <tr>
                                        <td>退勤時間</td>
                                        <td>
                                            <select>
                                                <option value="">当日</option>
                                                <option value="">翌日</option>
                                            </select>
                                        </td>
                                        <td><input name="end_work" type="time" value="<?= $times['end_work'] ?>"></td>
                                        <td class="edit"><button class="btn btn-outline-info" type="button">保存</button></td>
                                        <td class="edit"><button class="btn btn-outline-danger" type="button">削除</button></td>
                                    </tr>
                                    <tr>
                                        <td>休憩開始時間</td>
                                        <td>
                                            <select>
                                                <option value="">当日</option>
                                                <option value="">翌日</option>
                                            </select>
                                        </td>
                                        <td><input name="start_break" type="time" value="<?= $times['start_break'] ?>"></td>
                                        <td class="edit"><button class="btn btn-outline-info" type="button">保存</button></td>
                                        <td class="edit"><button class="btn btn-outline-danger" type="button">削除</button></td>
                                    </tr>
                                    <tr>
                                        <td>休憩終了時間</td>
                                        <td>
                                            <select>
                                                <option value="">当日</option>
                                                <option value="">翌日</option>
                                            </select>
                                        </td>
                                        <td><input name="end_break" type="time" value="<?= $times['end_break'] ?>"></td>
                                        <td class="edit"><button class="btn btn-outline-info" type="button">保存</button></td>
                                        <td class="edit"><button class="btn btn-outline-danger" type="button">削除</button></td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>

                        <input
                            type="hidden" name="_csrfToken" autocomplete="off"
                            value="<?= $this->request->getAttribute('csrfToken') ?>">

                        
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
                    </form>
                    

                </div>
                <?php echo $this->Html->script("modal"); ?>
            </div>
        </div>
        
</body>
</html>