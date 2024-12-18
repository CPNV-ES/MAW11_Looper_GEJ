<?php /**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description Basic template of the view
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" media="all" href="/assets/css/font-awesome.css">
    <link href="/assets/css/fontawesome/fontawesome.css" rel="stylesheet" />
    <link href="/assets/css/fontawesome/brands.css" rel="stylesheet" />
    <link href="/assets/css/fontawesome/solid.css" rel="stylesheet" />
    <title><?php echo $title ?></title>
</head>
<body>
    <?php echo $content ?>
</body>
</html>