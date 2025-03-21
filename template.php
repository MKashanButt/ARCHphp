<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getenv('APPNAME'); ?></title>

    <link rel="stylesheet" href="<?php echo getenv('STYLESHEETDIR') ?>global.css">
    <link rel="stylesheet" href="<?php echo getenv('STYLESHEETDIR') . $cssfilename; ?>">
</head>

<body>
    <?php include_once 'components/header.html'; ?>
    <?= $slot; ?>
    <?php include_once 'components/footer.html'; ?>
</body>

</html>