<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use sirgalas\menu\models\MenuGet;
use yii\web\View;
use sirgalas\menu\MenuAsset;
use kartik\select2\Select2;
use yii\helpers\Url;
use sirgalas\menu\MenuModule;
MenuAsset::register($this);
$menu=new MenuGet();
?>
    <?php
        $form = ActiveForm::begin();
                foreach ($module->models as $modul){
                    if(isset($modul['label'])){
                        $label=$modul['label'];
                    }else{
                        $label=$modul['class'];
                    } ?>
                    <?php echo '<div class="form-group field-menu" id="theSelectTwo" data-path="'.$modul['path'].'" data-class="'.$modul['class'].'" >';

                        $selectArr=$menuGet->addSelect($modul);
                    if(isset($module->imageSetPath)&&isset($module->imageResize)){
                        $url=Html::a(MenuModule::t('translit','Download image'),'#', ['data-url'=>Url::to(["/menu/menubackend/create"]), 'class'=>'showDropFile']);
                    }else{
                        $url='';
                    }
                      echo Select2::widget([
                         'name' => 'state_2',
                         'value' => '',
                         'data' => $selectArr,
                         'options' => ['placeholder' => $label],
                         'pluginEvents' => [
                             "select2:selecting" => "function(e) {
                                var print = log(e);
                                var parent = $(this).parents('#theSelectTwo')

                                var model= parent.data('class');
                                var path = parent.data('path');
                                var sortable = $('#menu-to-edit');
                                var value = sortable.html();
                                var text = print.args.data.text;
                                var alias = print.args.data.id;
                                var input = '<li class=\"ui-state-default wells\" data-path=\"'+path+'\" id=\"menus-'+count+'\" data-model=\"'+model+'\"  data-alias=\"'+alias+'\" data-title=\''+text+'\' data-depth=\"0\" data-item=\"'+count+'\" >'+text+'<span class= \"glyphicon glyphicon-remove del\"></span> <span class=\"glyphicon glyphicon-chevron-down showInput\"></span><p class=\"form-group hide\"><label>".MenuModule::t('translit','title')."<input type=\"text\"  class=\"form-control tilteInput\" placeholder=\"".MenuModule::t('translit','Enter title').".\" /></label></p><p class=\"form-group hide\"><label>".MenuModule::t('translit','class')."<input type=\"text\"  class=\"form-control classInput\" placeholder=\"".MenuModule::t('translit','Enter class')."\" /></label></p><p class=\"form-group hide\"><label>".MenuModule::t('translit','id')."<input type=\"text\" class=\"form-control idInput\" placeholder=\"".MenuModule::t('translit','Enter id')."\" /></label></p><p class=\"form-group hide\">".$url."</p></li>';
                                $('.dropFileHide').hide();
                                theInnerHtml=value +''+ input;
                                sortable.html(theInnerHtml);
                                count++; }"
                         ]
                     ]);

                    echo '</div>';
                }
            echo '<div class="form-group field-menu">';
            $selectMenu=$menuGet->addSelectMenu();
            echo Select2::widget([
                'name' => 'state_2',
                'value' => '',
                'data' => $selectMenu,
                'options' => ['placeholder' => MenuModule::t('translit','menuSelect')],
                'pluginEvents' => [
                "select2:selecting" => "function(e) {
                    var print = log(e);
                    var id = print.args.data.id;
                    var text = print.args.data.text;
                    var input = '<li class=\"ui-state-default wells\"  data-menu=\"'+id+'\"  data-depth=\"0\"  data-item=\"'+count+'\"  data-title=\''+text+'\' >'+text+'<span class= \"glyphicon glyphicon-remove del\"></span> <span class=\"glyphicon glyphicon-chevron-down showInput\"></span><p class=\"form-group hide\"><label>".MenuModule::t('translit','title')."<input type=\"text\"  class=\"form-control tilteInput\" placeholder=\"".MenuModule::t('translit','Enter title').".\" /></label></p><p class=\"form-group hide\"><label>".MenuModule::t('translit','class')."<input type=\"text\"  class=\"form-control classInput\" placeholder=\"".MenuModule::t('translit','Enter class')."\" /></label></p><p class=\"form-group hide\"><label>".MenuModule::t('translit','id')."<input type=\"text\" class=\"form-control idInput\" placeholder=\"".MenuModule::t('translit','Enter id')."\" /></label></p><p class=\"form-group hide\"><label>".MenuModule::t('translit','alias')."<input type=\"text\" class=\"form-control aliasInput\" placeholder=\"".MenuModule::t('translit','Enter alais')."\" /></label></p></li>';
                    count++;
                    $('.dropFileHide').hide();
                    var sortable = document.getElementById('menu-to-edit');
                    var value = sortable.innerHTML
                    sortable.innerHTML=value +''+ input;
                }"
                ]
            ]);
            echo '</div>';
        ActiveForm::end();

    ?>
