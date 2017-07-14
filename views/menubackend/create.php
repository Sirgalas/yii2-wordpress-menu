<?php
use yii\helpers\Html;
use yii\web\View;
use sirgalas\menu\MenuModule;
use yii\widgets\ActiveForm;
?>
<div class="menu-create patern">
    <h1><?= MenuModule::t('translit','Create menu') ?></h1>
    <div class="frontend-setup-form col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <?= $this->render('_form', [ 'model'=>$model,'module'=>$module,'menuGet'=> $menuGet,]) ?>
            <?php
            foreach($module->models as $key => $value) {}
            ?>
            <div class="dropFileHide">
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
            <?php
            if(isset(Yii::$app->modules['menu']->modelDb)) {
                $menuModel = Yii::$app->modules['menu']->modelDb;
                $menuSetup = new $menuModel();
                $name = $menuSetup->getName();
                $content = $menuSetup->getContent();
            }else{
                $name = 'name';
                $content = 'content';
            }
        $form = ActiveForm::begin(['id'=>'formMenu']);
            echo $form->field($model,$name)->textInput(['class'=>'name'])->label(MenuModule::t('translit','enterNameMenu')) ?>
            <ul id="menu-to-edit" class="sortable-ui connectedSortables" data-class="menus" data-name="<?= $modelForNameInput?>[<?= $content ?>]"></ul>
             <?php if(isset($module->extra_menu)){
                     for($i=$module->extra_menu;$i>0;$i--){
                        echo "<ul class=\"sortable-ui extra connectedSortables \" data-class=\"extra-".$i."\"></ul>";
                    }
                 }
            if(isset(Yii::$app->modules['menu']->modelDb)) {
                echo $form->field($model,$model->getServiceField())->hiddenInput(['value'=>$model->getNameServiceField()])->label(false);
            } ?>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton(MenuModule::t('translit','Save'), ['class' => 'btn btn-success', 'id' => 'secures','data-formurl'=>Yii::$app->urlManager->createUrl(['/menu/menubackend'])]); ?>
                            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>