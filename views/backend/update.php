<?php
/**
* @var $entities $sirgalas\menu\entities\MenuName
 */
use sirgalas\menu\MenuModule;
use kartik\select2\Select2;
use sirgalas\menu\MenuAsset;
use yii\widgets\ListView;

MenuAsset::register($this);
$this->title=MenuModule::t('translit','Update menu');
?>
<div class="menu-create patern">
    <div class="sirgalas-update-menu-form col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="box box-solid box-default">
                <div class="box-header"><?= MenuModule::t('translit','Menu title') ?></div>
                <div class="box-body">
                    <?=  $this->render('_form',compact('entities'))?>
                </div>
            </div>
            <div class=" box box-solid box-default">
                <div class="box-header"><?= MenuModule::t('translit','Select menu') ?></div>
                <div class="box-body">
                    <?php
                        foreach($datas as $key => $value) {
                            echo "<div class='form-group field-menu-item-name required'>";
                            echo Select2::widget([
                                'name' => 'state_2',
                                'value' => '',
                                'data' => $value,
                                'options' => ['placeholder' => MenuModule::t('translit','Select states'),'data-models'=>$key,'data-id'=>$entities->id],
                                'pluginEvents' => [
                                "select2:select" => "function(e) {
                                    var select = $(this);
                                     count=$('#menu-to-edit li').length;
                                     var location=window.location.search.replace('?id=','');
                                    var data='name='+select.data('models')+'&id='+select.val()+'&modelId='+select.data('id')+'&count='+count+'&menu='+location;
                                    $.ajax({
                                        type: 'POST',
                                        url:'/menu/backend/add-items',
                                        data: data,
                                        success: function(data){
                                            $('#menu-to-edit').append(data);
                                        }
                                    });
                                }"
                                ],
                            ]);
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
            <div class="dropFileHide">
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <div class="box box-solid box-default">
                <div class="box-header"><?= MenuModule::t('translit','Some menu') ?></div>
                <div class="box-body">
                    <ul id="menu-to-edit" class="sortablesMenu sortable-ui connectedSortables" data-class="menus">
                        <?= ListView::widget([
                            'dataProvider'  => $itemProvider,
                            'itemView'      => '_add_items',
                            'summary' => false,
                            'pager' => false
                        ]) ?>
                    </ul>
                    <?php
                    if($extra_menu){
                        foreach ($extra_menu as $key=>$extra){
                            ?>
                            <ul class="sortablesMenu sortable-ui extra connectedSortables " data-class="extra-<?= $key ?>" >

                            </ul>
                        <?php }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
</div>