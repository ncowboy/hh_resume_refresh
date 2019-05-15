<?php


namespace app\commands;

use app\models\HhData;
use yii\console\Controller;
use yii\httpclient\Client;

/**
 *  hh.ru resume refresh
 * @package app\commands
 */

class RefreshController extends Controller
{
  public function actionIndex($id){
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
      echo "Выполнено";
    } else {
      print_r($response->data);
    }
  }

}