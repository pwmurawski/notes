<html lang="pl">

<head>
  <title>Notatnik</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link href="/public/style.css" rel="stylesheet">
</head>

<body class="body">
  <div class="wrapper">
    <header class="header">
      <h1><i class="far fa-clipboard"></i>Moje notatki</h1>
    </header>

    <div class="container">
      <nav class="menu">
        <ul>
          <li><a href="/">Strona główna</a></li>
          <li><a href="/?action=create">Nowa notatka</a></li>
        </ul>
      </nav>

      <main class="page">
        <?php require_once("templates/pages/$page.php"); ?>
      </main>
    </div>

    <footer class="footer">
      <p>Notatki</p>
    </footer>
  </div>
</body>

</html>