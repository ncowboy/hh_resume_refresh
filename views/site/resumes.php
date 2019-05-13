<?php
use yii\helpers\Html;
?>
<div>
  <?= Yii::$app->session->getFlash('resumesError') ?>
</div>
<?php if (isset($resumes)): ?>
  <table class="table table-hover">
    <thead>
    <tr>
      <th>ФИО</th>
      <th>Название</th>
      <th>Дата последнего обновления</th>
      <th>Действия</th>
    </tr>
    </thead>
    <?php foreach ($resumes as $resume): ?>
      <tr>
        <td>
          <?= "{$resume['last_name']} {$resume['first_name']} {$resume['middle_name']}" ?>
        </td>
        <td>
          <?= $resume['title'] ?>
        </td>
        <td>
          <?= $resume['updated_at'] ?>
        </td>
        <td>
          <?= Html::a('Обновить', ['publish', 'id' => $resume['id']], [
            'class' => 'btn btn-primary',
            'data' => [
              'method' => 'post',
            ],
          ]) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

<?php endif; ?>




