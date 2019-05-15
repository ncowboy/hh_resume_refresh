<?php
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;

function isRefreshEnabled($resume) {
  return (time() - strtotime(date($resume['updated_at'])) > 60 * 60 * 4);
}

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
      <th>Обновление</th>
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
          <?= date('d M Y H:i:s', strtotime(date($resume['updated_at']))) ?>
        </td>
        <td>
          <?=
            Html::beginForm([Url::to(['publish', 'id' => $resume['id']])
            ]);
            echo Html::submitButton(FAS::icon('sync-alt'), [
                'class' => isRefreshEnabled($resume) ? 'btn btn-primary' : 'btn btn-danger',
                'title' => isRefreshEnabled($resume) ? 'Обновить' : 'Обновление не доступно',
                'disabled' => isRefreshEnabled($resume) ? false : 'disabled',
            ]);
            echo Html::endForm();
          ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

<?php endif; ?>




