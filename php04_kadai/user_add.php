<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ユーザ登録</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<style>
    body {
        text-align: center;
        background-color: #d1c0b5;
    }

    header,
    main,
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .navbar {
        width: 100%;
        justify-content: center;
    }

    .navbar-header {
        display: flex;
        justify-content: center;
    }

    .jumbotron {
        width: 100%;
        margin: 0;
        padding: 15px;
    }

    .book-container {
        display: flex;
        padding: 0.5rem;
        /* 8px if 1rem = 16px */
        border: 1px solid #D1D5DB;
        /* Tailwindのborder-gray-300に相当 */
        margin-bottom: 0.5rem;
        /* 8px if 1rem = 16px */
        background-color: #ffffff;
    }
</style>

<body>

    <!-- Head[Start] -->
    <header>
    <h1>読書記録</h1>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="select.php">データ一覧</a>
                    <a class="navbar-brand" href="index.php">書籍検索</a>
                    <a class="navbar-brand" href="user_add.php">ユーザー登録</a>
                    <a class="navbar-brand" href="user_show.php">ユーザー表示</a>
                </div>

            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="user_insert.php">
        <div class="jumbotron">
            <fieldset>
                <legend>追加ユーザー</legend>
                <label>ユーザー名：<input type="text" name="name"></label><br>
                <label>ユーザーID：<input type="text" name="lid"></label><br>
                <label>ユーザーPW：<input type="text" name="lpw"></label><br>
                <input type="submit" value="登録">
            </fieldset>
        </div>
    </form>
</body>

</html>