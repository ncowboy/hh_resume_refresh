<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\helpers\Html;

?>


<?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Наименование',
            'value' => $model->name,
            'captionOptions' => [
               'width' => '15%', 
            ]
        ],
        [
            'label' => 'Короткое описание',
            'value' => $model->short_description,
            'format' => 'html',   
        ],
        [
            'label' => 'Цена (руб.)',
            'value' => $model->price,
            'format' => 'currency',
        ],
        
    ],
]);
?>
<?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
