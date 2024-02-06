<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
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
          <a class="navbar-brand" href="index.php">書籍検索</a>
          <a class="navbar-brand" href="select.php">記録一覧</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <h3>書籍検索</h3>
  <p>
    <input type="text" id="keyword" value="">
    <button id="readbook">検索</button>
  </p>
  <p id="warn"></p>
  <main>
    <div id="content" class=""></div>
  </main>


  <!-- コメント登録とページ遷移 -->
  <form method="post" action="insert.php">
    <div class="jumbotron">
      <fieldset>
        <legend>コメント</legend>
        <input type="hidden" name="insert_dt" id="insert_dt">
        <input type="hidden" name="image_url" id="image_url">
        <input type="hidden" name="book_title" id="book_title">
        <input type="hidden" name="book_author" id="book_author">
        <input type="hidden" name="book_publisher" id="book_publisher">
        <label><textArea name="naiyou" rows="4" cols="40" id="comment"></textArea></label><br>
        <input type="submit" value="登録" id="submit" disabled>
      </fieldset>
    </div>
  </form>

  <!-- 登録完了ポップアップ -->
  <div id="popup" class="popup-overlay">
    <div class="popup-content">
      <h2>登録完了</h2>
      <p>登録が完了しました。</p>
      <button id="close-popup">閉じる</button>
    </div>
  </div>

  <!-- Main[End] -->

  <script>
    //検索のenter機能は送信ボタンとの兼ね合いでコメントアウト
    // $(document).ready(function() {
    //   $(document).on('keypress', function(e) {
    //     if (e.which == 13) { // 13はEnterキーのキーコードです
    //       $('#readbook').click(); // ボタンのIDを指定してクリックイベントをトリガー
    //     }
    //   });
    // });

    // 手順
    // 1. axios を使って 情報を取得する
    // 2. JSONデータ構造を基に本のタイトルを取得する
    // 3. 本のタイトル情報をHTMLに出力する
    // ---ここからは課題！
    // 4. クリックイベントで括る
    // 5. id="keyword"の入力値を取得 → URLの"?q=jquery"の"queryの文字を取得した入力値（変数）に変える"
    // 6. 出版社も表示してみよう！（データ構造はconsole.logで確認！！）

    // コメントと書籍選択状態をチェックする関数
    function checkConditions() {
      var comment = $('#comment').val().trim();
      var isBookSelected = $('.book-container:visible').length === 1;

      if (comment && isBookSelected) {
        $('#submit').prop('disabled', false).addClass('enabled');
      } else {
        $('#submit').prop('disabled', true).removeClass('enabled');
      }
    };

    // コメント欄の変更を監視
    $('#comment').on('input', function() {
      checkConditions();
    });

    // 書籍選択時の処理
    $(document).on('click', '.book-container', function() {
      // 既存の書籍選択ロジック...
      checkConditions();
    });


    // axios を使う[開始]
    $("#readbook").on('click', function() {
      //alert('click!');
      if ($("#keyword").val() == "") {
        if ($("#warn:contains('キーワードを入力して下さい')").length == 0) {
          $("#warn").append("キーワードを入力して下さい")
        }
      } else {
        $("#warn").empty();
        $("#content").empty();

        // id="keyword"の入力値を取得 → URLの"?q=jquery"の"queryの文字を取得した入力値（変数）に変える"
        const keyword = $("#keyword").val();
        const url = "https://www.googleapis.com/books/v1/volumes?q=" + keyword;

        // axiosを使って情報を取得する
        axios.get(url).then(function(res) {
          console.log(res.data);
          const items = res.data.items
          // 配列の中身を一つずつ取り出してみて表示する
          items.forEach(function(item, index) {
            var maxLen = 100;
            var description = item.volumeInfo.description;
            // descriptionが定義されていて、最大長より長い場合は切り詰める
            if (description && description.length > maxLen) {
              description = description.substring(0, maxLen) + '...';
            };
            // 出版社も表示してみよう！（データ構造はconsole.logで確認！！）
            //""はタイトル、''はそのタイトルの文字列定義用

            var authors = item.volumeInfo.authors || []; // authorsがundefinedの場合は空の配列を使用
            var publisher = item.volumeInfo.publisher || '-'; // 出版社がundefinedの場合のデフォルトテキスト
            var thumbnail;
            if (item.volumeInfo && item.volumeInfo.imageLinks && item.volumeInfo.imageLinks.thumbnail) {
              thumbnail = item.volumeInfo.imageLinks.thumbnail;
            } else {
              thumbnail = 'noimage.jpeg';
            };

            var title = item.volumeInfo.title || '-'; // 出版社がundefinedの場合のデフォルトテキスト

            if ($("#content:contains('" + item.volumeInfo.title + "')").length == 0) {
              $("#content").append(
                `<div class="book-container" data-book-id="${index}">
                 <img src='${thumbnail}' class="book-thumbnail"/>
                 <div class="book-details">
                   <h2 class="book-title">${title}</h2>
                   <p class="book-author">著者: ${authors.join(', ')}</p>
                   <p class="book-publisher">出版社: ${publisher}</p>
                   <p class="book-description">${description}</p>
                 </div>
               </div>`
              )
            }
          })
          // 選択されている書籍のIDを追跡する変数
          var selectedBookId = null;

          // 書籍をクリックしたときのイベントハンドラー
          $(document).on('click', '.book-container', function() {
            var bookId = $(this).data('book-id');

            // 選択された書籍の情報を隠しフィールドにセット
            $('#image_url').val($(this).find('.book-thumbnail').attr('src'));
            $('#book_title').val($(this).find('.book-title').text());
            $('#book_author').val($(this).find('.book-author').text());
            $('#book_publisher').val($(this).find('.book-publisher').text());

            if (selectedBookId === bookId) {
              // 同じ書籍が再度クリックされた場合、全ての書籍を表示
              $('.book-container').show();
              selectedBookId = null;
            } else {
              // 別の書籍がクリックされた場合、その書籍のみ表示
              $('.book-container').hide();
              $(`[data-book-id="${bookId}"]`).show();
              selectedBookId = bookId;
            }
          });
        })
      };
    });

    $(document).ready(function() {
      $('form').on('submit', function(event) {
        event.preventDefault(); // デフォルトのフォーム送信を阻止

        // 現在の日時をセット
        $('#insert_dt').val(new Date().toISOString());

        // フォームデータを取得
        var formData = $(this).serialize();

        // コンソールにフォームデータを表示
        console.log('送信されるフォームのデータ:', formData);

        // AJAXを使用してデータを送信
        $.ajax({
          type: "POST",
          url: "insert.php",
          data: formData,
          success: function(data) {
            // 成功時の処理
            //console.log('サーバーからの応答:', data);
            $('#popup').show(); // ポップアップを表示
          },
          error: function(xhr, status, error) {
            // エラー時の処理
            //console.error('送信エラー:', status, error);
          }
        });
      });

      // ポップアップを閉じるイベント
      $('#close-popup').on('click', function() {
        $('#popup').hide();
      });
    });
  </script>

</body>

</html>