<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use sirgalas\menu\MenuModule;
use yii\helpers\Url;
?>
<?php $form =ActiveForm::begin(['id'=>'formMenu']); ?>
    <?= $form->field($entities,'name')->textInput(); ?>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= Html::submitButton(MenuModule::t('translit','Save'), ['class' => 'btn btn-success', 'id' => 'secures','data-formurl'=>Url::to('/menu/menubackend')]); ?>
    </div>
<?php ActiveForm::end(); ?>