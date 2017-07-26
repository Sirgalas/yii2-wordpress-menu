<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.06.17
 * Time: 21:50
 */

namespace sirgalas\menu;


use sirgalas\menu\models\Menu;
use sirgalas\menu\models\MenuViews;
use yii\base\Widget;

use Yii;
class MenuView extends Widget
{
    public $home;
    public $name;
    public $nameAlias;
    public $nav;
    public $navBar;
    public $menu;
    public $dropdown;
    public function init(){
        parent::init();
    }
    public function run(){
        $modelMenu= new Menu();
        if(isset(Yii::$app->modules["menu"]["modelDb"])) {
            $menuModel = Yii::$app->modules["menu"]["modelDb"];
            $model=new $menuModel;

            $menuQuery=$menuModel::find()->where([$model->getName()=>$this->name])->one();

            $content=$model->getContent();
            $allMenu=$menuModel::find()->where([$model->getServiceField()=>$model->getNameServiceField()])->all();

        }else{
            $allMenu=Menu::find()->all();
            $menuQuery=Menu::find()->where(['name'=>$this->name])->one();
            $content='content';
        }
        $dropdown=$this->dropdown ? $this->dropdown:false ;
        $model= new Menu();
        if(!empty($this->menu)) {
            return $this->render('menuviews/index', [
                'home' => $this->home,
                'menu' => $this->menu,
                'menuQuery' => $menuQuery,
                'model' => $model,
                'content' => $content,
                'modelMenu' => $modelMenu,
                'allMenu' => $allMenu,
                'nameAlias' => $this->nameAlias,
                'dropdown' => $dropdown,
                'allProperties' => get_object_vars($this)

            ]);
        }else if(!empty($this->nav)){
            return $this->render('menuviews/index', [
                'home' => $this->home,
                'nav' => $this->nav,
                'navBar' => $this->navBar,
                'menuQuery' => $menuQuery,
                'model' => $model,
                'content' => $content,
                'modelMenu' => $modelMenu,
                'allMenu' => $allMenu,
                'nameAlias' => $this->nameAlias,
                'dropdown' => $dropdown,
                'allProperties' => get_object_vars($this)

            ]);
        }else{
            $modelMenu= new Menu();
            return $this->render($modelMenu->renderMenu($allMenu,$menuQuery,$content,$this->nameAlias));
        }

    }

}