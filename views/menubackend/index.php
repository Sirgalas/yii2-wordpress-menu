<?php

use yii\helpers\Html;
use yii\grid\GridView;
use sirgalas\menu\MenuModule;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FrontendSetupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = MenuModule::t('translit','Menu setup');
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div class="frontend-setup-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(MenuModule::t('translit','Create menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
   
    if(empty($module->modelDb)){
         echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    }else{
        $menuModel=Yii::$app->modules['menu']->modelDb;
        $menuSetup=new $menuModel;
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                $menuSetup->getName(),
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php } ?>
</div>
