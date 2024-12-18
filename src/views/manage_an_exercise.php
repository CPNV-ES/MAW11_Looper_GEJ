<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description manage an exercise view
 */

$title = 'ExerciseLooper';

ob_start();
?>

<header class="heading results">
  <section class="container">
    <a href="/"><img src="/assets/img/logo.png"></a>
  </section>
</header>

<main class="container">

  <div class="row">
    <section class="column">
      <h1>Building</h1>
      <table class="records">
        <thead>
          <tr>
            <th>Title</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($buildingExercises as $exercise): ?>
          <tr>
            <td><?= $exercise->getTitle() ?></td>
            <td>
              <?php if ($exercise->getFieldsCount() > 0) {?>
                <a title="Be ready for answers" rel="nofollow" data-method="put"
                  href="/exercises/<?= $exercise->getId() ?>?exercise%5Bstatus%5D=answering"><i class="fa fa-comment"></i></a>
              <?php }?>
              <a title="Manage fields" href="/exercises/<?= $exercise->getId() ?>/fields"><i class="fa fa-edit"></i></a>
              <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete"
                href="/exercises/<?= $exercise->getId() ?>/delete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section class="column">
      <h1>Answering</h1>
      <table class="records">
        <thead>
          <tr>
            <th>Title</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($answeringExercises as $exercise): ?>
          <tr>
            <td><?= $exercise->getTitle() ?></td>
            <td>
              <a title="Show results" href="/exercises/<?= $exercise->getId() ?>/results"><i class="fa fa-chart-bar"></i></a>
              <a title="Close" rel="nofollow" data-method="put" href="/exercises/<?= $exercise->getId() ?>?exercise%5Bstatus%5D=closed"><i
                  class="fa fa-minus-circle"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section class="column">
      <h1>Closed</h1>
      <table class="records">
        <thead>
          <tr>
            <th>Title</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($closeExercises as $exercise): ?>
          <tr>
            <td><?= $exercise->getTitle() ?></td>
            <td>
              <a title="Show results" href="/exercises/<?= $exercise->getId() ?>/results"><i class="fa fa-chart-bar"></i></a>
              <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete"
                href="/exercises/<?= $exercise->getId() ?>/delete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>
</main>

<?php
$content = ob_get_clean();
require VIEW_DIR . '/template.php';
?>