<?php
    if(!isset($_SESSION['date'])){
        $_SESSION['date'] = "";
    }
    if(isset($_POST['attend'])) {
        $_SESSION['flag'] = 1;
        $_SESSION['date'] = date('Y/m/d');
    }
    if(isset($_POST['leave'])) {
        $_SESSION['flag'] = 2;
    }
    if(isset($_POST['restStart'])) {
        $_SESSION['flag'] = 3;
    }
    if(isset($_POST['restFinish'])) {
        $_SESSION['flag'] = 4;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <?php echo $this->Html->css("home"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/header'); ?>
    <?php echo $this->Html->script("home"); ?>
</head>
<body>
    <div id="main">
        <div class="Card">
            <div id="now">
                <div id="nowDate">
                    <!-- 日時 -->
                    <!-- ページ読込の際のダミーデータ -->0000/00/00
                </div>
                <div id="nowTime">
                    <!-- 現在時刻 -->
                    <!-- ページ読込の際のダミーデータ -->00:00:00
                </div>
            </div>
            <form method="POST">
                <div class="buttonFlex">
                    <button name="attend" class="engButton" id="attendanceButton" <?php echo $_SESSION['date'] == "" || isset($_SESSION['flag']) && $_SESSION['flag'] == 2 && $_SESSION['date'] != date('Y/m/d') ? '' : 'disabled' ?> value="出勤">出勤</a></button>
                    <button name="leave" class="engButton" id="leavingButton" <?php echo isset($_SESSION['flag']) && $_SESSION['flag'] == 1 || isset($_SESSION['flag']) && $_SESSION['flag'] == 4 ? '' : 'disabled' ?> value="退勤">退勤</button>

                </div>
                <div class="buttonFlex">
                    <button name="restStart" class="engButton" id="restStartButton" <?php echo isset($_SESSION['flag']) && $_SESSION['flag'] == 1 ? '' : 'disabled' ?> value="休憩開始">休憩開始</button>
                    <button name="restFinish" class="engButton" id="restFinishButton" <?php echo isset($_SESSION['flag']) && $_SESSION['flag'] == 3 ? '' : 'disabled' ?> value="休憩終了">休憩終了</button>
                </div>
                <input
                        type="hidden" name="_csrfToken" autocomplete="off"
                        value="<?= $this->request->getAttribute('csrfToken') ?>">
            </form>
        </div>
        <div class="Card" id="userInfoCard">
            <div id="userList">

                <h2 id="userListTitle">登録社員</h2>
                    

                    <!-- 検索ボックス -->
                    <div id="searchBox">
                        <?= $this->Form->create(null, ['type' => 'post']) ?>
                            <?php echo $this->Form->input('find',['placeholder'=>'社員名を入力してください','required'=>'required']); ?>
                            <button name="searchButton"><i class="fas fa-search"></i></button>
                        <?= $this->Form->end() ?>
                    </div>
                    
                <div class="scroll_bar">
                    <?php $i=0; ?>
                    <!-- 検索で１人も当てはまらなかった場合 -->
                    <?php if(isset($count)): ?>
                        <p id="searchMessage">
                            <?php if($count == 0): echo '検索結果が見つかりません'; endif; ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php $i = 0; ?>
                    <?php foreach ($users as $user): ?>
                        <div id="userNameList">
                            <p id="userName"><?= h($user->last_name) ?><?= h($user->first_name) ?></p>
                            <div id="userLabel"><?= $status[$i] ?></div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
