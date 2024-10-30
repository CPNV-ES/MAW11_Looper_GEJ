<?php
$title = 'Method Not Allowed';

http_response_code(500);

ob_start();
?>

<script>
<?php foreach(explode("\n", $console_log) as $log): ?>
console.log("<?= $log ?>")
<?php endforeach; ?>
</script>
<h1>Error 500 - Internal Server Error</h1>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>