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
        <div><button id="backButton"><i class="fas fa-arrow-circle-left fa-3x"></i></button></div>

        <div id="userId_Name">
            <div><p>ID:123456</p></div>
            <div><p>社員名:横田守生</p></div>
        </div>

        <div><h1 id="pageTitle">勤務表履歴</h1></div>
        <div><p id="pageDate">10月3日</p></div>

            <div>
                <table>
                    <tr>
                        <th>出勤時間</th>
                        <th>退勤時間</th>
                        <th>休憩開始時間</th>
                        <th>休憩終了時間</th>
                    </tr>
                    <tr>
                        <td><input type="time" value="09:00" ></td>
                        <td><input type="time" value="09:00"></td>
                        <td><input type="time" value="09:00"></td>
                        <td><input type="time" value="09:00"></td>
                    </tr>
                </table>
            </div>

            <div id="buttonBox">
                    <div id="changeButton"><button type="button">保存する</button></div>
                    <div id="cancelButton"><button id="open" type="button">キャンセル</button></div>
            </div>
            
            <div id="mask" class="hidden"></div>
            <section id="modal" class="hidden">
                <p>編集が完了してません。<br>終了してよろしいですか？</p>
                <div id="close">
                    <p>はい</p>
                </div>
                <div id="close">
                    <p>いいえ</p>
                </div>
            </section>
        
    </div>
    <?php echo $this->Html->script("modal"); ?>
</body>
</html>