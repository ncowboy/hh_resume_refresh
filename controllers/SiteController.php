<?php

namespace app\controllers;

use app\models\HhData;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use Yii;

class SiteController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
          'publish' => ['post'],
        ],
      ],
    ];
  }

  /**
   * @inheritdoc
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    $data = HhData::findOne(1);
    if (isset($data) && $data->access_token_expire >= strtotime(date('Y-m-d H:i:s'))) {
      return $this->render('index', [
        'token' => $data,
      ]);
    } else {
      Yii::$app->session->setFlash('isTokenExist', 'Токен приложения отсутствует или просрочен. Обновите токен');
      return $this->render('index');
    }
  }

  /**
   * Auth action.
   *
   * @return string
   */
  public function actionAuth($code)
  {
    if (!$data = HhData::findOne(1)) {
      $data = new HhData();
    }
    $data->authorization_code = $code;
    if ($data->save()) {
      $client = new Client();
      $response = $client->createRequest()
        ->setMethod('POST')
        ->setUrl('https://hh.ru/oauth/token')
        ->setData([
          'grant_type' => 'authorization_code',
          'client_id' => Yii::$app->hh->client_id,
          'client_secret' => Yii::$app->hh->client_secret,
          'redirect_uri' => Yii::$app->hh->redirect_uri,
          'code' => $code,
        ])
        ->send();
      if ($response->isOk) {
        Yii::$app->session->setFlash('isTokenExist', 'Токен успешно получен');
        $data->access_token = $response->data['access_token'];
        $data->refresh_token = $response->data['refresh_token'];
        $data->access_token_expire = strtotime(date('Y-m-d H:i:s')) + $response->data['expires_in'];
      } else {
        Yii::$app->session->setFlash('isTokenExist', "{$response->data['error']} <br> {$response->data['error_description']} ");
      }
      if ($data->save()) {
        return $this->redirect('/');
      }
    }
  }

  public function actionResumes()
  {
    $data = HhData::findOne(1);
    $client = new Client();
    $response = $client->createRequest()
      ->setMethod('GET')
      ->setUrl('https://api.hh.ru/resumes/mine')
      ->setHeaders([
        'Authorization' => 'Bearer ' . $data->access_token,
        'User-Agent' => 'api-test-agent'
      ])
      ->send();
    if ($response->isOk) {
      return $this->render('resumes', [
        'resumes' => $response->data['items']
      ]);
    } else {
      Yii::$app->session->setFlash('resumesError', "
        {$response->data['description']} <br>
        {$response->data['errors'][0]['value']} <br>
        {$response->data['errors'][0]['type']} <br>
       
        "
      );
      return $this->render('resumes');
    }
  }

  public function actionPublish($id)
  {
    $data = HhData::findOne(1);
    $client = new Client();
    $response = $client->createRequest()
      ->setMethod('POST')
      ->setUrl("https://api.hh.ru/resumes/{$id}/publish")
      ->setHeaders([
        'Authorization' => 'Bearer ' . $data->access_token,
        'User-Agent' => 'api-test-agent'
      ])
      ->send();
    if ($response->isOk) {
      return $this->redirect('resumes');
    }
  }

}
