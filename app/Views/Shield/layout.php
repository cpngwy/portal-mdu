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
    <style>
        
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            opacity: 0.8;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/themes/sb-admin-2-gh-pages/img/loading-2.gif') center no-repeat #000000;
            /* https://smallenvelop.com/wp-content/uploads/2014/08/Preloader_21.gif */
        }
    
    </style>
</head>
<!-- style="background-image: url('/themes/sb-admin-2-gh-pages/img/custom-svg/undraw_secure-login_m11a.svg'); background-size: 94% 94%; background-repeat: no-repeat; background-attachment: fixed;" -->
<div class="se-pre-con"></div>
<body class="bg-light mt-2">

    <main role="main" class="container">

        <?= $this->renderSection('main') ?>
    
    </main>

<?= $this->renderSection('pageScripts') ?>
</body>
</html>
<script src="/themes/sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
<script>
$(function () {
    $(".se-pre-con").delay(1000).fadeOut("slow");

    $("form").submit(function(){
        $(".se-pre-con").fadeIn(100);
    });
});
</script>