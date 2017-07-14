<?php
use yii\widgets\ActiveForm;
use sirgalas\menu\MenuModule;

if(isset($found)){
    if(isset($found['image'])){ ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id'=>'dropzone']]) ?>
            <?= \zainiafzan\widget\Dropzone::widget([
                'options' => [
                    'addRemoveLinks'    => true,
                    'url'               => 'create',
                ],
                'clientEvents' => [
                    'complete' => "function(file,dataUrl){
                        var date = new Date();
                        var mm = date.getMonth() + 1; // месяц 1-12
                        if (mm < 10) mm = '0' + mm;
                        var path = '".$module->imageSetPath."'+date.getFullYear()+\"/\"+mm;
                        var li= $('ul li#".$id."');
                        console.log(li);
                        var liHtml=li.html();
                        var src= path+'/'+file.name;
                        var image = '<image src=\"'+src+'\" data-pathImage=\"'+path+'\" data-fileName=\"'+file.name+'\" />';
                        var addHtml = image+liHtml;
                        li.html(addHtml);
                        
                    }",
                    'removedfile' => "function(file){
                        var value = document.getElementById('gods-image').value;
                        string= file.name
                        if(value.indexOf(string)!=-1){
                            newvalue = value.replace(string,'');
                        }else if(value.indexOf(file.name)!=-1){
                            newvalue = value.replace(file.name,'');
                        }else{
                            newvalue = value
                        }                 
                        document.getElementById('gods-image').setAttribute('value',newvalue);
                    }",
                    'success'=>'function(file){}',
                    'sending' => "function(file, xhr, formData){formData.append('".Yii::$app->request->csrfParam."','".Yii::$app->request->getCsrfToken() ."')}"
                ]
            ])?>
        <?php ActiveForm::end() ?>
    <?php } else {
        echo MenuModule::t('translit','ErrorNotImage');
    } ?>
<?php } else {
    echo MenuModule::t('translit','ErrorNotPath');
}?>