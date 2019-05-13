<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;  
?>


<?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Наименование',
            'value' => $model->name,
        ],
        [
            'label' => 'Подробное описание',
            'value' => $model->full_description,
            'format' => 'html',   
        ],
        [
            'label' => 'Цена (руб.)',
            'value' => $model->price,
            'format' => 'currency',
        ],
    ],
]);