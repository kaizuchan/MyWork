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
</head>
<body>
    <div>

        <!-- 戻るボタン -->
        <?php echo $this->element('components/backButton'); ?>

        <div id="userId_Name">
            <div><p>ID:123456</p></div>
            <div><p>横田守生</p></div>
        </div>

        <div><h1 id="pageTitle">勤務表履歴</h1></div>
        <div><p id="pageDate">10月3日</p></div>
        
            <form method="post">
                <div>
                    <table>
                        <tr>
                            <th>出勤時間</th>
                            <th>退勤時間</th>
                            <th>休憩開始時間</th>
                            <th>休憩終了時間</th>
                        </tr>
                        <tr>
                            <td><input name="start_work" type="time" value="<?= $times['start_work'] ?>" ></td>
                            <td><input name="end_work" type="time" value="<?= $times['end_work'] ?>"></td>
                            <td><input name="start_break" type="time" value="<?= $times['start_break'] ?>"></td>
                            <td><input name="end_break" type="time" value="<?= $times['end_break'] ?>"></td>
                        </tr>
                    </table>
                </div>

                <input
                    type="hidden" name="_csrfToken" autocomplete="off"
                    value="<?= $this->request->getAttribute('csrfToken') ?>">

                <div id="buttonBox">
                        <div id="changeButton"><button type="submit">保存する</button></div>
                        <div id="cancelButton"><button id="open" type="button">キャンセル</button></div>
                </div>
                
                <div id="mask" class="hidden"></div>
                <section id="modal" class="hidden">
                    <p id="editMessage">編集が完了してません。<br>終了してよろしいですか？</p>
                    <div  id="selectButton">
                        <div class="close">
                            <p id="yesButton">はい</p>
                        </div>
                        <div class="close">
                            <p id="noButton">いいえ</p>
                        </div>
                    </div>
                </section>
            </form>
            
        
    </div>
    <?php echo $this->Html->script("modal"); ?>
</body>
</html>