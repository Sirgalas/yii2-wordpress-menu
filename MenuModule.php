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
    public $modelDb;
    //public $model;
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
            'basePath'       => '@vendor/sirgalas/yii2-wordperss-menu/messages',
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('sirgalas/menu/'.$category, $message, $params, $language);
    }



    public function getAllModels(){
        if(isset($this->model)) {
            if(isset($model['label'])){
                $label=$this->model['label'];
            }else{
                $label='выбрать '.$this->model['class'];
            }
           $model[$label] = ArrayHelper::map($this->model['class']::find()->asArray()->all(),$this->model['id'],$this->model['title']);;
        }
        if(isset($this->models)){
            foreach ($this->models as $models){
                    if(isset($models['label'])){
                        $label=$models['label'];
                    }else{
                        $label='выбрать '.$models['class'];
                    }
                    $model[$label.'%'.$models['class'].'%'.$models['path'].'%'.$models['alias']]=ArrayHelper::map($models['class']::find()->asArray()->all(),$models['id'],$models['title']);
            }

        }
        return $model;
    }
    

    /**
     * @inheritdoc
     */
   
}
