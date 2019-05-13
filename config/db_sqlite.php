<?php

$db_path=realpath(__DIR__."/../data")."/db.db";

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . $db_path
];
