<?php

namespace sirgalas\menu\models;

use Yii;
use yii\helpers\ArrayHelper;
use sirgalas\menu\MenuModule;
use yii\helpers\Html;
use yii\helpers\Url;


class MenuGet extends Menu
{
    public function addSelect($models){
        return ArrayHelper::map($models['class']::find()->asArray()->all(),$models['alias'],$models['title']);
    }

    public function addSelectMenu(){
        if(isset(Yii::$app->modules['menu']->modelDb)) {
            $test=Yii::$app->modules['menu']->modelDb;
            $model=new $test;
            return ArrayHelper::map($test::find()->where([$model->getServiceField()=>$model->getNameServiceField()])->asArray()->all(),$model->getIdMenuBechavior(),$model->getName());
        }else{
            return ArrayHelper::map(Menu::find()->asArray()->all(),'id','name');
        }
    }

    public function getMenu($json,$module,$name){
        if(isset($json->$name)){
            $str='';
            $count=0;
            $idStr=substr(key($json->$name),0,-1).'s';
            foreach ($json->$name as $menu){
                if(isset($menu->imgPath)){
                     $img =Html::img($menu->imgPath.'/'.$menu->imgName,['data-pathimage'=>$menu->imgPath,'data-filename'=>$menu->imgName]);
                }else{
                    $img='';
                }
                    $str .= "<li id=\"$idStr-$count\" class=\"ui-state-default wells\" data-path=\"$menu->path\" data-model=\"$menu->model\" data-alias=\"$menu->alias\" data-title=\"$menu->title\" data-depth=\"$menu->depth\"  data-item=\"$count\"><span class=\"image\">$img</span> $menu->title";
                    $str .= "<span class=\"glyphicon glyphicon-remove del\"></span>";
                    $str .= "<span class=\"glyphicon glyphicon-chevron-down showInput\"></span>";
                    $str .= "<p class=\"form-group hide\"><label>" . MenuModule::t('translit', 'title') . "<input class=\"form-control tilteInput\" placeholder=\" " . MenuModule::t('translit', 'Enter title') . "\" type=\"text\"></label></p>";
                    $str .= "<p class=\"form-group hide\"><label>" . MenuModule::t('translit', 'class') . "<input class=\"form-control  classInput\" value=\"".$menu->classItem."\" placeholder=\"" . MenuModule::t('translit', 'Enter class') . "\" type=\"text\"></label></p>";
                    $str .= "<p class=\"form-group hide\"><label>" . MenuModule::t('translit', 'id') . "<input class=\"form-control idInput\"   value=\"".$menu->idInput."\"  placeholder=\"" . MenuModule::t('translit', 'Enter id') . "\" type=\"text\"></label></p>";
                    $str .= "<p class=\"form-group hide\"><label>".MenuModule::t('translit','alias')."<input type=\"text\" class=\"form-control aliasInput\" value=\"".$menu->aliasInput."\" placeholder=\"".MenuModule::t('translit','Enter alais')."\" /></label></p>";
                    if (!empty($module->imageSetPath) && !empty($module->imageResize)) {
                        $str .= '<p class="form-group hide">';
                        $str .= Html::a(MenuModule::t('translit', 'Download image'), '#', ['data-url' => Url::to(["/menu/menubackend/create"]), 'class' => 'showDropFile']);
                        $str .= '</p>';
                    }

                $str .='</li>';
                $count++;

            }
            return $str;
        }else{
            return MenuModule::t('translit','notMenu');
        }
    }
}
