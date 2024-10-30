<?php
$title = 'Page Not Found';

http_response_code(404);

ob_start();
?>

<h1>Error 404 - Page not found</h1>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>