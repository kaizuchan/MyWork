<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Bootstrap 4 Website Layout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link href="style.css" rel="stylesheet">
    <?php echo $this->Html->css("header"); ?>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-light sticky-top">
    <div class="container-fluid">
        <a href="/">
            <div id="logo">
                <?php
                    echo $this->Html->image("LOGO_04.png");
                    ?>
            </div>
        </a>
        <div id="enterprise">
        <p><?= $enterprise ?></p>
        </div>



        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="/admin">管理者</a>
                </li>
                <li class="nav-item active">
                    <a href="/works">勤怠履歴</a>
                </li>
                <li class="nav-item active">
                    <a href="/logout">ログアウト</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>