<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description Edit a field view
 */

$title = 'ExerciseLooper';

$kind = $field->getKind();

ob_start();
?>

<header class="heading managing">
    <section class="container">
        <a href="/"><img src="/assets/img/logo.png"></a>
        <span class="exercise-label">New exercise</span>
    </section>
</header>

<main class="container">
    <h1>Editing Field</h1>

    <form
        action="/exercises/<?= $exercise->getId() ?>/fields/<?= $field->getId() ?>"
        accept-charset="UTF-8" method="post">
        <div class="field">
            <label for="field_label">Label</label>
            <input type="text" value="<?= $field->getLabel() ?>"
                name="field[label]" id="field_label">
        </div>

        <div class="field">
            <label for="field_value_kind">Value kind</label>
            <select name="field[value_kind]" id="field_value_kind">
                <option <?= $kind == Kind::SingleLineText ? 'selected' : '' ?>
                    value="single_line">Single line text</option>
                <option <?= $kind == Kind::ListOfSingleLines ? 'selected' : '' ?> value="single_line_list">List of single lines</option>
                <option <?= $kind == Kind::MultiLineText ? 'selected' : '' ?> value="multi_line">Multi-line text</option>
            </select>
        </div>

        <div class="actions">
            <input type="submit" name="commit" value="Update Field" data-disable-with="Update Field">
        </div>
    </form>
</main>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>