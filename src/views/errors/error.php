<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description Error display pages
 */

$title = $error_message;

http_response_code($return_code);

ob_start();
?>

<h1>Error <?= $return_code ?> - <?= $error_message ?></h1>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>