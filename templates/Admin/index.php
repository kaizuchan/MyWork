<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
    <?php echo $this->Html->css("administrator"); ?>
    <!-- 戻るアイコンボタン　コンポーネントリンク -->
    <?php echo $this->Html->css("backButton"); ?>
    <!-- ヘッダー -->
    <?php echo $this->element('components/headerAdmin'); ?>
    <!-- モーダルウィンドウ -->
    <?php echo $this->Html->css("modal"); ?>
</head>
<body>
    <div id="main">

        <!-- 戻るボタン -->
        <?php echo $this->element('components/backButton'); ?>

        <!-- 検索ボックス -->
        <div id="searchBox">
            <?= $this->Form->create(null, ['type' => 'post']); ?>
                <?php echo $this->Form->input('find',['label'=>['text'=>'社員名を入力してください'],'required'=>'required']); ?>
                <?php echo $this->Form->button('検索',['name'=>'searchButton']); ?>
            <?= $this->Form->end() ?>
        </div>
        <div>
            <div id="userListItem">
                <div><p id="userIdItem">社員ID</p></div>
                <div><p id="userNameItem">社員名</p></div>
                <div><p id="userChangeButtonItem">編集</p></div>
            </div>

            <div id="form">
                <?= $this->Form->create(null, ['type' => 'post']); ?>
                    <?php if(isset($_POST['searchButton'])){ ?>
                            <?php foreach ($searchUsers as $searchUser): ?>
                                <div class="userList">
                                <div>
                                    <?php echo $this->Form->checkbox('delete[]',
                                    ['value' => $searchUser->id,'hiddenField' => false]); ?>
                                    <label for="userId" id="userId"><?= $searchUser->employee_id ?></label></div>
                                <div><p id="userName"><?= $searchUser->last_name.$searchUser->first_name ?></p></div>
                                <div><i class="fas fa-pencil-alt fa-2x"></i></div>
                            </div>
                            <?php endforeach; ?>
                        <?php }else{ ?>
                                <?php foreach ($users as $user): ?>
                                    <div class="userList">
                                        <div>
                                            <input type="checkbox" name="delete[]" value="<?= $user->id ?>">
                                            <label for="userId" id="userId"><?= $user->employee_id ?></label>
                                        </div>
                                        <div><p id="userName"><?= $user->last_name.$user->first_name ?></p></div>
                                        <div><i class="fas fa-pencil-alt fa-2x"></i></div>
                                    </div>
                                <?php endforeach; ?>
                        <?php } ?>
                    <div id="mask" class="hidden"></div>
                    <section id="modal" class="hidden">
                        <p id="editMessage">上記の社員を本当に削除しますか？<br>(「OK」をクリックすると元には戻せません。)</p>
                        <div  id="selectButton">
                            <div id="yesClose">
                                <button id="yesButton" name="yesButton">OK</button>
                            </div>
                            <div id="noClose">
                                <button id="noButton">キャンセル</button>
                            </div>
                        </div>
                    </section>
            
            </div>
        <?= $this->Form->end() ?>
        <div id="add-deleteButton">
                <a href="/Admin/adduser" id="addButton"><i class="fas fa-plus fa-3x"></i></a>
                <div id="deleteButton"><button id="open" name="deleteButton"><i class="fas fa-trash-alt fa-3x"></i></button></div>
        </div>

    </div>
    <?php echo $this->Html->script("modal"); ?>
</body>
</html> 