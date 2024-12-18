<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description show fulfillment result view
 */

$title = 'ExerciseLooper';

ob_start();
?>


<header class="heading results">
	<section class="container">
		<a href="/"><img src="/assets/img/logo.png"></a>
		<span class="exercise-label">Exercise: <a href="/exercises/<?=$exercise->getId()?>/results"><?=$exercise->getTitle()?></a></span>
	</section>
</header>

<main class="container">
	<h1><?=$fulfillment->getTimestamp()?></h1>
	<dl class="answer">
		<?php foreach ($fulfillment->getFields() as $i => $field): ?>
		<dt><a href="/exercises/<?= $exercise->getId() ?>/results/<?= $field->getId() ?>"><?= $field->getLabel() ?></a></dt>
		<dd><?= $field->getBody() ?></dd>
		<?php endforeach; ?>
	</dl>

	<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>