<?php

use app\models\Account;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RepositorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Github scan';
?>
<div class="site-index">

    <h1><?= $this->title ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'account.name',
                'label' => 'Программа',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'account_id',
                    'data' => ArrayHelper::map(Account::getActiveList(), 'id', 'name'),
                    'value' => $searchModel->account_id,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'selectOnClose' => true,
                    ]
                ])
            ],
            'name',
            'updated_at:datetime',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
