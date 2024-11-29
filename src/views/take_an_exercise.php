<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description take an exercise
 */

$title = 'ExerciseLooper';

ob_start();
?>

<link rel="stylesheet" href="/assets/css/exercises_root.css">

<header class="heading answering">
	<section class="container">
		<a href="/"><img src="/assets/img/logo.png" /></a>
	</section>
</header>

<main class="container">

	<ul class="answering-list">
		<?php foreach ($exercises as $exercise): ?>
		<li class="row">
			<div class="column card">
				<div class="title">
					<?= htmlspecialchars($exercise->getTitle()); ?>
				</div>
				<a class="button"
					href="/exercises/<?= $exercise->getId(); ?>/fulfillments/new">Take
					it</a>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</main>
<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>