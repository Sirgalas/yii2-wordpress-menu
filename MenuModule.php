<?php

namespace sirgalas\menu;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * transliter module definition class
 */
class MenuModule extends \yii\base\Module
{
    /**
     * @var
     */
    public $models;
    public $label;
    public $imageDownloadPath;
    public $imageSetPath;
    public $imageResize;
    public $extra_menu;
    public $controllerNamespace = 'sirgalas\menu\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }


    public function registerTranslations()
    {
        Yii::$app->i18n->translations['sirgalas/menu/translit'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath'       => '@vendor/sirgalas/yii2-wordpress-menu/messages',
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('sirgalas/menu/'.$category, $message, $params, $language);
    }

    public function getArrEntities(){
        $datas=array();
        foreach ($this->models as $model){
            $entities=new $model;
            $datas[$model]=ArrayHelper::map($model::find()->asArray()->all(),$entities->getId(),$entities->getTitle());
        }
        if(empty($datas))
            throw new \RuntimeException(self::t('app','not model data menu'));
        return $datas;
    }
    
    public function getExtraMenu(){
        $extra_arr=array();
        if($this->extra_menu)
            return array_pad($extra_arr,$this->extra_menu,0);
        return false;
            
    }
    
    

    /**
     * @inheritdoc
     */
   
}
