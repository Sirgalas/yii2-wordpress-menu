<?php
use yii\widgets\Menu;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
$contents=json_decode($menu->$content);
$arrMenu= array();
if(isset($home)){
    $arrMenu[] = ['label' => $home,'url' => [Yii::$app->homeUrl]];
}

foreach ($contents->menus as $decode) {
    if (isset($decode->menuItem)) {
        $arrMenu[] = ['label' => $decode->text, 'url' => '', 'items' => $modelMenu->Menu($allMenu,$decode->menuItem,$content,$nameAlias), 'linkOptions'=>['data-toggle'=>'not']];
    } elseif($decode->depthMenu){
        foreach ($decode->depthMenu as $depth){
            $item[] = [
                'label' => $depth->title,
                'url' => [
                    $depth->path,
                    $nameAlias => $depth->alias
                ]
            ];
        }
        $arrMenu[] = ['label' => $decode->text, 'url' => '', 'items' => $items, 'linkOptions'=>['data-toggle'=>'not']];
    }
    else {
        $arrMenu[] = ['label' => $decode->title,'url' => [$decode->path,$nameAlias=>$decode->alias]];
    }
}



if($navWidget=='menu'){
    echo Menu::widget([
        'items'             =>  $arrMenu,
        'labelTemplate'     =>  $labelTemplate,
        'linkTemplate'      =>  $linkTemplate,
        'options'           =>  $navBarOption,
        'encodeLabels'      =>  $encodeLabels,
        'activeCssClass'    =>  $activeCssClass,
        'firstItemCssClass' =>  $firstItemCssClass,
        'lastItemCssClass'  =>  $lastItemCssClass,
    ]);
}
if($navWidget=='navbar'){
    NavBar::begin([
        'brandLabel'        =>  $brandLabel,
        'brandUrl'          =>  $brandUrl,
        'options'           =>  $navBarOption,
        'containerOptions'  =>  $containerOptions,
    ]);
    echo Nav::widget([
        'options'   =>  $navOption,
        'items'     =>  $arrMenu,
    ]);
    NavBar::end();
}

 ?> 