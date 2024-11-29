<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description submit or edit an exericise
 */

$title = 'ExerciseLooper';

ob_start();
?>

<header class="heading answering">
	<section class="container">
		<a href="/"><img src="/assets/img/logo.png"></a>
		<span class="exercise-label">Exercise: <span
				class="exercise-title"><?=$exercise->getTitle()?></span></span>
	</section>
</header>

<main class="container">
	<h1>Your take</h1>
	<?php if (isset($fulfillment_id)): ?>
		<p>Bookmark this page, it's yours. You'll be able to come back later to finish.</p>
	<?php else: ?>
		<p>If you'd like to come back later to finish, simply submit it with blanks</p>
	<?php endif; ?>
	<form action="<?= isset($fulfillment_id) ? "/exercises/$exercise_id/fulfillments/$fulfillment_id" : "/exercises/$exercise_id/fulfillments" ?>" accept-charset="UTF-8" method="post">
		<?php foreach ($fields as $field): ?>
			<input type="hidden" value="<?=$field->getId()?>"
				name="fulfillment[answers_attributes][<?=$field->getId()?>][field_id]">
			<div class="field">
				<label
					for="<?=$field->getId()?>"><?=$field->getLabel()?></label>
				<?php $body = $field instanceof FulfillmentField ? $field->getBody() : '' ?>
				<?php if($field->getKind()->value == 0): ?>
					<input type="text" value="<?= $body ?>" id="<?=$field->getId()?>"
						name="fulfillment[answers_attributes][<?=$field->getId()?>][value]">
				<?php else: ?>
					<textarea
						name="fulfillment[answers_attributes][<?=$field->getId()?>][value]"><?= $body ?></textarea>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<div class="actions">
			<input type="submit" name="commit" value="Save" data-disable-with="Save">
		</div>
	</form>
</main>




<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>