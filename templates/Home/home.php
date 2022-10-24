<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <?php echo $this->Html->css("home"); ?>
    <!-- ヘッダー -->
    <?php
        if($me->role == 1){
            echo $this->element('components/headerNormalUser'); 
        }else if($me->role == 2){
            echo $this->element('components/header'); 
        }
    ?>
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
                    <button name="attend" class="engButton" id="attendanceButton" <?php echo $flag == "" || $flag == 4  ? '' : 'disabled' ?>>出勤</button>
                    <button name="leave" class="engButton" id="leavingButton" <?php echo $flag == 1 || $flag == 3 ? '' : 'disabled' ?>>退勤</button>

                </div>
                <div class="buttonFlex">
                    <button name="restStart" class="engButton" id="restStartButton" <?php echo $flag == 1 || $flag == 3 ? '' : 'disabled' ?>>休憩開始</button>
                    <button name="restFinish" class="engButton" id="restFinishButton" <?php echo $flag == 2 ? '' : 'disabled' ?>>休憩終了</button>
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
                            <div id="userLabel" class="userLabel"><?= $status[$i] ?></div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->Html->script("home"); ?>
</body>
</html>
