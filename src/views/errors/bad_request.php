<?php
$title = 'Bad Request';

http_response_code(400);

ob_start();
?>

<h1>Error 400 - Bad Request</h1>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>