<?php

/* @var $this yii\web\View */

$this->title = 'HH Resume';

?>

<h2>Запрос токена</h2>
<?php if (Yii::$app->session->getFlash('isTokenExist')): ?>
  <div class="help-block <?= !isset($token) ? 'alert alert-danger' : 'alert alert-success' ?>">
    <?= Yii::$app->session->getFlash('isTokenExist') ?>
  </div>
<?php endif; ?>
<p>Токен: <?= isset($token) ? $token->access_token : '' ?></p>
<p>Действителен до: <?= isset($token) ? date('d:m:Y H:i:s', $token->access_token_expire) : '' ?></p>
<form action="https://hh.ru/oauth/authorize">
  <input name="response_type" type="hidden" value="code">
  <input name="client_id" type="hidden" value="<?= Yii::$app->hh->client_id ?>">
  <input name="redirect_uri" type="hidden" value="<?= Yii::$app->hh->redirect_uri ?>">
  <input class="btn btn-success" type="submit" value="Получить / обновить токен">
</form>






