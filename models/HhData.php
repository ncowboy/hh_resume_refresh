<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hh_data".
 *
 * @property int $id
 * @property string $authorization_code
 * @property string $access_token
 * @property string $refresh_token
 * @property int $access_token_expire
 */
class HhData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hh_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authorization_code'], 'string'],
            [['access_token_expire'], 'integer'],
            [['access_token', 'refresh_token'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authorization_code' => 'Authorization Code',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'access_token_expire' => 'Access Token Expire',
        ];
    }
}
