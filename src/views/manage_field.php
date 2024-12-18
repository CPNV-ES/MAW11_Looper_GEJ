<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description Manage a field view
 */

$title = 'ExerciseLooper';

ob_start();
?>

<header class="heading managing">
    <section class="container">
        <a href="/"><img src="/assets/img/logo.png"></a>
        <span class="exercise-label">New exercise</span>
    </section>
</header>

<main class="container">

    <div class="row">
        <section class="column">
            <h1>Fields</h1>
            <table class="records">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Value kind</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fields as $field): ?>
                    <tr>
                        <td><?= $field->getLabel() ?></td>
                        <td>
                        <?php
						switch($field->getKind()) {
							case Kind::SingleLineText:
								echo 'single_line';
								break;
							case Kind::ListOfSingleLines:
								echo 'single_line_list';
								break;
							case Kind::MultiLineText:
								echo 'multi_line';
								break;
						}
                    	?>
                        </td>
                        <td>
                            <a title="Edit"
                                href="/exercises/<?= $exercise->getId() ?>/fields/<?= $field->getId() ?>/edit"><i
                                    class="fa fa-edit"></i></a>
                            <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete"
                                href="/exercises/<?= $exercise->getId() ?>/fields/<?= $field->getId() ?>"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a class="button" 
			
				<?php if (count($exercise->getFields()) <= 0):?>
				disabled href="#">
				<?php else:?>
                href="/exercises/<?= $exercise->getId() ?>?exercise%5Bstatus%5D=answering">
				<?php endif; ?>
				
				<i class="fa fa-comment"></i> Complete and be ready for answers</a>

        </section>
        <section class="column">
            <h1>New Field</h1>
            <form
                action="/exercises/<?= $exercise->getId() ?>/fields"
                accept-charset="UTF-8" method="post">

                <div class="field">
                    <label for="field_label">Label</label>
                    <input type="text" name="field[label]" id="field_label">
                </div>

                <div class="field">
                    <label for="field_value_kind">Value kind</label>
                    <select name="field[value_kind]" id="field_value_kind">
                        <option selected="selected" value="single_line">Single line text</option>
                        <option value="single_line_list">List of single lines</option>
                        <option value="multi_line">Multi-line text</option>
                    </select>
                </div>

                <div class="actions">
                    <input type="submit" name="commit" value="Create Field" data-disable-with="Create Field">
                </div>
            </form>
        </section>
    </div>

    <?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>