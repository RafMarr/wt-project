<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <script src="js/theme-loader.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <title><?php echo $templateParams["titolo"]; ?></title>
</head>

<body class="container-fluid mode-bg-text p-0 m-0">
    <a href="#main-content" class="visually-hidden">Vai al contenuto principale</a>
    <header class="text-center theme-bg-text py-2">
        <a class="nav-link" href="index.php"><h1>Campus+</h1></a>
    </header>
    <?php
    if (!isset($templateParams["no-nav"])) {
        require 'template/page-nav.php';
    }
    ?>
    <main id="main-content" class="pt-3 pb-5 mt-1">
        <?php
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
        ?>
    </main>

    <!-- Footer -->

    <!-- JS -->
    <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>

    <!-- Bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>


</html>