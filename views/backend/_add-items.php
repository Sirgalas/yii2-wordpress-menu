<?php 

/**
* @var $entities \yii\db\ActiveRecord
 */

use sirgalas\menu\MenuModule;


?>
<li class="ui-state-default wells" data-path="<?= $model->path; ?>" id="menus-<?= $count ?>" data-model="<?= $className ?>"  data-alias="<?= $entities->alias ?>" data-title='<?= $entities->title ?>' data-depth="0" data-item="0" >
    <span class="image"></span> <?= $entities->title ?>
    <span class= "glyphicon glyphicon-remove del"></span>
    <span class="glyphicon glyphicon-chevron-down showInput"></span>
    <p class="form-group hide">
        <label>"<?= MenuModule::t('translit','title'); ?>"
            <input type="text"  class="form-control tilteInput" placeholder="<?= MenuModule::t('translit','Enter title'); ?>" />
        </label>
    </p>
    <p class="form-group hide">
        <label>"<?= MenuModule::t('translit','class'); ?>"
            <input type="text"  class="form-control classInput" placeholder="<?= MenuModule::t('translit','Enter class'); ?>" />
        </label>
    </p>
    <p class="form-group hide">
        <label>"<?= MenuModule::t('translit','id'); ?>"
            <input type="text" class="form-control idInput" placeholder="<?= MenuModule::t('translit','Enter id'); ?>" />
        </label>
    </p>
    <p class="form-group hide">
        <label>"<?= MenuModule::t('translit','alias'); ?>"
            <input type="text" class="form-control aliasInput" placeholder="<?= MenuModule::t('translit','Enter alais'); ?>" />
        </label>
    </p>
    <p class="form-group hide">".$url."</p>
</li>