<?php
$title = $error_message;

http_response_code($return_code);

ob_start();
?>

<h1>Error <?= $return_code ?> - <?= $error_message ?></h1>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>