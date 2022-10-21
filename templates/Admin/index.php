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
    <!-- エラーメッセージや成功メッセージ -->
    <?php echo $this->Html->css("message"); ?>
</head>
<body>

    <?= $this->Flash->render() ?><!-- ← レイアウトになければ追加 -->

    <div id="main">

        <div class="Card">

        <!-- 戻るボタン -->
        <?php echo $this->element('components/backButton'); ?>

            <!-- 検索ボックス -->
            <div id="searchBox">
                <?= $this->Form->create(null, ['type' => 'post', 'id' => 'searchForm']); ?>
                    <?php echo $this->Form->input('find',['placeholder'=>'社員名を入力してください','required'=>'required']); ?>
                    <button name="searchButton"><i class="fas fa-search"></i></button>
                <?= $this->Form->end() ?>
            </div>
                
                
                <div id="add-deleteButton">
                        <a href="/Admin/adduser" id="addButton"><i class="fas fa-user-plus fa-3x"></i></a>
                        <div id="deleteButton"><button id="open" name="deleteButton" onclick="myCheck();"><i class="fas fa-trash-alt fa-3x"></i></button></div>
                </div>
                <!-- 検索結果 -->
                <?php if(isset($count)): ?>
                    <p id="searchMessage">
                        <?php if($count == 0): echo '検索結果が見つかりません'; endif; ?>
                    </p>
                <?php endif; ?>

                    
                <div class="scroll_bar">
                    <div id="form">
                        <table class="table table-hover">
                                <thead  class="table-light">
                                    <tr id="thead">
                                        <th scope="col"><i class="fas fa-check-square"></i></th>
                                        <th scope="col">社員ID</th>
                                        <th scope="col">社員名</th>
                                        <th scope="col">編集</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= $this->Form->create(null, ['type' => 'post']); ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr id="tbody">    
                                                <td id="checkBox"><input class="check" type="checkbox" name="delete[]" value="<?= $user->id ?>"></td>
                                                <td id="userId" class="userInfo"><p><?= $user->employee_id ?></p></td>
                                                <td id="userName" class="uName"><a href="/admin/works/<?= $user->id ?>"><p><?= $user->last_name.$user->first_name ?></p></a></td>
                                                <td id="editButton"><a href="/admin/edit-user/<?= $user->id ?>"><i class="far fa-edit fa-2x"></i></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <div id="mask" class="hidden"></div>
                <section id="modal" class="hidden">
                    <div id="delete_scl">
                        <?php foreach ($users as $user): ?>
                            <input id="deleteList" class="deleteList" type="hidden" value="" readonly="readonly">
                        <?php endforeach; ?>
                    </div>
                    <p id="editMessage">
                        <i class="fas fa-exclamation-triangle" id="exclamation-triangleIcon"></i>
                        上記の社員を本当に削除しますか？<br>(「OK」をクリックすると元には戻せません)
                    </p>
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

    <?php echo $this->Html->script("modal"); ?>
</body>
</html> 