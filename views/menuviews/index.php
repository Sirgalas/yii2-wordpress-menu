<?php
use yii\widgets\Menu;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
$contents=json_decode($menuQuery->$content);
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

if(!empty($menu)){
    $menu['items']=$arrMenu;
    echo Menu::widget(
        $menu
    );

}
if(!empty($nav)){
    NavBar::begin($nav);
    $navBar['items']=$arrMenu;
    echo Nav::widget($navbar);
    NavBar::end();
}