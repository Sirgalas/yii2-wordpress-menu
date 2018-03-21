<?php
/**
 * @var $entities sirgalas\menu\entities\MenuName
 */


use sirgalas\menu\MenuModule;

?>
<div class="menu-create patern">
    <h1><?= MenuModule::t('translit','Create menu') ?></h1>
    <div class="frontend-setup-form col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_form',compact('entities')) ?>
    </div>
</div>
