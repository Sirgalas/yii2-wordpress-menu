<?php


namespace sirgalas\menu\models;

use Yii;
use yii\db\ActiveRecord;
use sirgalas\menu\MenuModule;
use sirgalas\menu\behaviors\MenuBaseWordpressBehavior;
class Menu extends ActiveRecord
{

    public $imageFile;
    public static function tableName()
    {
        if(isset(Yii::$app->modules['menu']->modelDb)){
            $menuModel=Yii::$app->modules['menu']->modelDb;
            $menuSetup=new $menuModel;
            return $menuSetup->getDbName();
        }else{
            return '{{%menu_table}}';
        }

    }

    public function rules()
    {

            return [
                [['name', 'content'], 'required'],
                [['content'], 'string'],
                [['name'], 'string', 'max' => 510],
                [['name'], 'unique'],
                [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ];

    }
    public function attributeLabels()
    {

            $returnArray = array([
                'id' => 'id',
                'name' => MenuModule::t('translit', 'Name'),
                'content' => MenuModule::t('translit', 'Content'),
            ]);

        return $returnArray;
    }
    public function Menu($menus,$parentId,$content,$nameAlias){
        $item=[];
        foreach ($menus as $menu){
            if($menu->id==$parentId){
                $dropMenu = json_decode($menu->$content);
                $dropMenuArr = array();
                $objectVars = get_object_vars($dropMenu);
                foreach ($objectVars as $key => $value) {
                    if (strpos($key,'extra') ===0) {
                        foreach ($value as $jsonDecode) {
                            $item[] = [
                                'label' => $jsonDecode->title,
                                'url' => [
                                    $jsonDecode->path,
                                    $nameAlias => $jsonDecode->alias,
                                    'option' => ['class' => 'extra']
                                ]
                            ];
                        }
                    }else{
                        foreach ($value as $jsonDecode) {
                            $item[] = [
                                'label' => $jsonDecode->title,
                                'url' => [
                                    $jsonDecode->path,
                                    $nameAlias=>$jsonDecode->alias
                                ]
                            ];
                        }
                    }
                }
            }
        }
        return $item;
    }

    public function renderMenu($menu,$nameAlias,$allMenu=null,$content=null){
        $contents=json_decode($menu->$content);
        foreach ($contents->menus as $decode) {
            if (isset($decode->menuItem)) {
                if(!isset(Yii::$app->modules['menu']->modelDb)) {
                    $allMenu=Menu::find()->all();
                    $content='content';
                }
                $dropMenuAll = $this->Menuarr($allMenu,$decode->menuItem,$content,$nameAlias);// встроиная таблица забыл
                $arrMenu[] = ['label' => $decode->text, 'url' => '', 'items' => $dropMenuAll];
            }elseif(isset($decode->depthMenu)){
                $dropMenuAll = $this->menuDepthArr($decode->depthMenu);
                $arrMenu[] = ['label' => $decode->text, 'url' => '', 'items' => $dropMenuAll];
            }
            else {
                $arrMenu[] = ['label' => $decode->title,'url' => [$decode->path,$nameAlias=>$decode->alias]];
            }
        }
        return $arrMenu;
    }

    public function Menuarr($allMenu,$parentId,$content){
        $item=[];
        foreach ($allMenu as $menu){
            if($menu->id==$parentId){
                $dropMenu = json_decode($menu->$content);
                $objectVars = get_object_vars($dropMenu);
                foreach ($objectVars as $key => $value) {
                    if (strpos($key, 'extra') === 0) {
                        foreach ($value as $keys => $val) {
                            $item[$keys]=$val;
                        }
                        $item['option']='extra';
                    }else{
                        foreach ($value as $keys => $val) {
                            $item[$keys]=$val;
                        }
                        $item['option']='menu';
                    }
                }
            }
        }
        return $item;
    }

    public function menuDepthArr($menus)
    {
        $item=[];
        $objectVars = get_object_vars($menus);
        foreach ($objectVars as $key => $value) {
            if (strpos($key, 'extra') === 0) {
                foreach ($value as $keys => $val) {
                    $item[$keys]=$val;
                }
                $item['option']='extra';
            }else{
                foreach ($value as $keys => $val) {
                    $item[$keys]=$val;
                }
                $item['option']='menu';
            }
        }
        return $item;
    }
}