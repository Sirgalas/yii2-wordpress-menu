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
    public $navWidget;
    public $brandUrl;
    public $brandLabel;
    public $navBarOption;
    public $containerOptions;
    public $navOption;
    public $dropdown;
    public $encodeLabels;
    public $labelTemplate;
    public $linkTemplate;
    public $activeCssClass;
    public $firstItemCssClass;
    public $lastItemCssClass;
    public function init(){
        parent::init();
    }
    public function run(){
        $modelMenu= new Menu();
        if(isset(Yii::$app->modules["menu"]["modelDb"])) {
            $menuModel = Yii::$app->modules["menu"]["modelDb"];
            $model=new $menuModel;
            $menu=$menuModel::find()->where([$model->getName()=>$this->name])->one();
            $content=$model->getContent();
            $allMenu=$menuModel::find()->where([$model->getServiceField()=>$model->getNameServiceField()])->all();

        }else{
            $allMenu=Menu::find()->all();
            $menu=Menu::find()->where(['name'=>$this->name])->one();
            $content='content';
        }

        $containerOptions=['class' => 'container'];
        $navOption=['class' => 'nav navbar-nav'];
        $navBarOption=['class' => 'navbar navbar-default',];
        $dropdown=false;
        $encodeLabels=true;
        $labelTemplate ='{label} Label';
        $activeCssClass ='active';
        $firstItemCssClass = 'first';
        $lastItemCssClass = 'last';
        $linkTemplate = '<a href="{url}">{label}</a>';
        if(isset($this->containerOptions)){
            $containerOptions=$this->containerOptions;
        }
        if($this->navOption){
            $navOption=$this->navOption;
        }
        if($this->navBarOption){
            $navBarOption=$this->navBarOption;
        }

        if($this->dropdown){
            $dropdown=$this->dropdown;
        }
        if($this->encodeLabels){
            $encodeLabels=$this->encodeLabels;
        }
        if($this->labelTemplate){
            $labelTemplate=$this->labelTemplate;
        }
        if($this->linkTemplate){
            $linkTemplate=$this->linkTemplate;
        }

        $model= new Menu();
        if($this->navWidget){
            return $this->render('menuviews/index',[
                'home'          =>  $this->home,
                'menu'          =>  $menu,
                'model'         =>  $model,
                'content'       =>  $content,
                'modelMenu'     =>  $modelMenu,
                'allMenu'       =>  $allMenu,
                'nameAlias'     =>  $this->nameAlias,
                'navWidget'     =>  $this->navWidget,
                'brandUrl'      =>  $this->brandUrl,
                'brandLabel'    =>  $this->brandLabel,
                'navBarOption'  =>  $navBarOption,
                'containerOptions'  =>  $containerOptions,
                'navOption'         =>  $navOption,
                'dropdown'          =>  $dropdown,
                'encodeLabels'      =>  $encodeLabels,
                'allProperties'     =>  get_object_vars($this),
                'labelTemplate'     =>  $labelTemplate,
                'linkTemplate'      =>  $linkTemplate,
                'activeCssClass'    =>  $activeCssClass,
                'firstItemCssClass' =>  $firstItemCssClass,
                'lastItemCssClass'  =>  $lastItemCssClass,


            ]); 
        }else{
            $modelMenu= new Menu();
            return $this->render($modelMenu->renderMenu($allMenu,$menu,$content,$this->nameAlias));
        }
        
    }

}