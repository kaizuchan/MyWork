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
            <form>
                <div class="buttonFlex">
                    <button class="engButton" id="attendanceButton">出勤</a></button>
                    <button class="engButton" id="leavingButton">退勤</button>
                </div>
                <div class="buttonFlex">
                    <button class="engButton" id="restStartButton">休憩開始</button>
                    <button class="engButton" id="restFinishButton">休憩終了</button>
                </div>
            </form>
        </div>
        <div>
            <div id="userList">

                <h2 id="userListTitle">登録社員</h2>
                    
                
                    <!-- 検索ボックス -->
                    <div class="input-group">
                        <div id="searchBox"><?= $this->Form->create(null, ['type' => 'post']) ?></div>
                        <?php echo $this->Form->input('find',['label'=>['text'=>'社員名を入力してください'],'required'=>'required']); ?>
                        <div><?php echo $this->Form->button('検索',['name'=>'searchButton']); ?></div>
                        <!-- <button class="btn btn-outline-success" type="button" id="button-addon2"><i class="fas fa-search"></i></button> -->
                        <?= $this->Form->end() ?>
                    </div>
                    
                    <?php if(isset($_POST['searchButton'])){ ?>
                        <?php foreach ($searchUsers as $searchUser): ?>
                            <div id="userNameList">
                                <p id="userName"><?= h($searchUser->last_name) ?></p>
                                <div id="userLabel">出勤</div>
                            </div>
                        <?php endforeach; ?>
                    <?php } ?>

                    <?php foreach ($users as $user): ?>
                        <div id="userNameList">
                            <p id="userName"><?= h($user->last_name) ?></p>
                            <div id="userLabel">出勤</div>
                        </div>
                    <?php endforeach; ?>


            </div>
        </div>
    </div>
</body>
</html>
