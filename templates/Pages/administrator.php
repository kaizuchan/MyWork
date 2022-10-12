<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
    <?php echo $this->Html->css("home"); ?>
</head>
<body>
    <div id="main">
        <div class="input-group">
            <form id="searchBox">
                <input type="text" class="form-control" placeholder="社員名を入力してください">
                <button class="btn btn-outline-success" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
            </form>
        </div>
        
        <div>
            <div id="userListItem">
                <div><p id="userIdItem">社員ID</p></div>
                <div><p id="userNameItem">社員名</p></div>
                <div><p id="userChangeButtonItem">編集</p></div>
            </div>

            <div id="userList">
                <div><input type="checkbox"><label for="userId" id="userId">1</label></div>
                <div><p id="userName">豊﨑崇良</p></div>
                <div><i class="fas fa-pencil-alt fa-2x"></i></div>
            </div>

            <div id="userList">
                <div><input type="checkbox"><label for="userId" id="userId">1</label></div>
                <div><p id="userName">豊﨑崇良</p></div>
                <div><i class="fas fa-pencil-alt fa-2x"></i></div>
            </div>
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