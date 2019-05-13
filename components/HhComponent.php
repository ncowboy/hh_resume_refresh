<?php


namespace app\components;


use yii\base\Component;

/**
 * Class HhComponent
 * @package app\components
 * @property string $client_id Идентификатор, полученный при создании приложения.
 * @property string $client_secret Значение, выданное при регистрации приложения.
 * @property string $redirect_uri uri для перенаправления пользователя после авторизации. Если не указать, используется из настроек приложения. При наличии происходит валидация значения. Вероятнее всего, потребуется сделать urlencode значения параметра
 */
class HhComponent extends Component
{

  /**
   * @inheritdoc
   */


  public $client_id;
  public $client_secret;
  public $redirect_uri;

}