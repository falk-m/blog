<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title) ?> | falk-m.de</title>

    <link href="<?php echo $baseUrl ?>/public/styles/preflight.css" rel="stylesheet">
    <link href="<?php echo $baseUrl ?>/public/styles/layout.css" rel="stylesheet">
    <link href="<?php echo $baseUrl ?>/public/styles/components.css" rel="stylesheet">
    <link href="<?php echo $baseUrl ?>/public/highlightjs/styles/default.css" rel="stylesheet">
</head>

<body>
    <div class="l-container">
        <?= $this->section('content') ?>
    </div>

    <script src="<?php echo $baseUrl ?>/public/highlightjs/highlight.min.js"></script>

    <script>
        hljs.highlightAll();
    </script>
</body>

</html>