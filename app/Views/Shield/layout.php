<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $this->renderSection('title') ?></title>
    
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- CPN Favicon -->
    <link rel="icon" type="image/x-icon" href="/themes/sb-admin-2-gh-pages/img/CPN-Fav-ICON.png">
    <?= $this->renderSection('pageStyles') ?>
</head>
<!-- style="background-image: url('/themes/sb-admin-2-gh-pages/img/custom-svg/undraw_secure-login_m11a.svg'); background-size: 94% 94%; background-repeat: no-repeat; background-attachment: fixed;" -->
<body class="bg-light mt-2">

    <main role="main" class="container">

        <?= $this->renderSection('main') ?>
    
    </main>

<?= $this->renderSection('pageScripts') ?>
</body>
</html>
