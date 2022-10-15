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
    <?php echo $this->element('components/header'); ?>
</head>
<body>
    <div id="main">

        <div><button id="backButton"><i class="fas fa-arrow-circle-left fa-3x"></i></button></div>

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

            <?php if(isset($_POST['searchButton'])){ ?>
                <div id="userList">
                    <?php foreach ($searchUsers as $searchUser): ?>
                        <div><input type="checkbox"><label for="userId" id="userId"><?= $searchUser->employee_id ?></label></div>
                        <div><p id="userName"><?= $searchUser->last_name.$searchUser->first_name ?></p></div>
                        <div><i class="fas fa-pencil-alt fa-2x"></i></div>
                    <?php endforeach; ?>
                </div>
                <?php }else{ ?>
                    <div id="userList">
                        <?php foreach ($users as $user): ?>
                                <div><input type="checkbox"><label for="userId" id="userId"><?= $user->employee_id ?></label></div>
                                <div><p id="userName"><?= $user->last_name.$user->first_name ?></p></div>
                                <div><i class="fas fa-pencil-alt fa-2x"></i></div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
            
        </div>
        

        <div id="add-deleteButton">
            <form>
                <button id="addButton"><i   class="fas fa-plus fa-3x"></i></button>
                <button id="deleteButton"><i  class="fas fa-trash-alt fa-3x"></i></button>
            </form>
        </div>
    </div>
</body>
</html>