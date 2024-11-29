<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description show exercise result view
 */

$title = 'ExerciseLooper';

ob_start();
?>
<header class="heading results">
	<section class="container">
		<a href="/"><img src="/assets/img/logo.png"></a>
		<span class="exercise-label">Exercise: <a
				href="/exercises/<?=$exercise->getId()?>/results"><?=$exercise->getTitle()?></a></span>
	</section>
</header>
<main class="container">
	<table>
		<thead>
			<tr>
				<th>Take</th>
				<?php foreach ($exercise->getFields() as $field): ?>
				<th><a
						href="/exercises/<?=$exercise->getId()?>/results/<?=$field->getId()?>"><?=$field->getLabel()?></a>
				</th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($exercise->getFulfillments() as $fulfillment) : ?>
			<tr>
				<td><a
						href="/exercises/<?=$exercise->getId()?>/fulfillments/<?=$fulfillment->getId()?>"><?=$fulfillment->getTimestamp()?></a>
				</td>
				<?php foreach ($exercise->getFields() as $i => $field):
					$len = strlen($fulfillment->getFields()[$i]->getBody());
					if ($len == 0):?>
				<td class="answer"><i class="fa fa-times empty"></i></td>
				<?php elseif ($len > 10):?>
				<td class="answer"><i class="fa fa-check-double filled"></i></td>
				<?php else: ?>
				<td class="answer"><i class="fa fa-check short"></i></td>
				<?php endif; ?>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</main>
<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>