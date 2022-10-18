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
        <div>
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
                    <button name="attend" class="engButton" id="attendanceButton">出勤</a></button>
                    <button name="leave" class="engButton" id="leavingButton">退勤</button>

                </div>
                <div class="buttonFlex">
                    <button name="restStart" class="engButton" id="restStartButton">休憩開始</button>
                    <button name="restFinish" class="engButton" id="restFinishButton">休憩終了</button>
                </div>
                <input
                        type="hidden" name="_csrfToken" autocomplete="off"
                        value="<?= $this->request->getAttribute('csrfToken') ?>">
            </form>
        </div>
        <div>
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
                    <!-- 検索結果 -->
                    <?php if(isset($count)): ?>
                        <p id="searchMessage">
                            <?php if($count == 0): echo '検索結果が見つかりません'; endif; ?>
                        </p>
                    <?php endif; ?>
                    <?php if(isset($_POST['searchButton'])){ ?>
                        <?php foreach ($searchUsers as $searchUser): ?>
                            <div id="userNameList">
                                <p id="userName"><?= h($searchUser->last_name) ?><?= h($searchUser->first_name) ?></p>
                                <div id="userLabel"><?= $searchStatus[$i] ?></div>
                            </div>
                        <?php $i++; endforeach; ?>
                    <?php }else{ ?>
                        <?php foreach ($users as $user): ?>
                            <div id="userNameList">
                                <p id="userName"><?= h($user->last_name) ?><?= h($user->first_name) ?></p>
                                <div id="userLabel"><?= $status[$i] ?></div>
                            </div>
                        <?php $i++; endforeach; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
