<?php
/**
 * @property string $name
 * @property string $content
 * @property integer $name_table_id
 * @property integer $parent_id
 * @property integer $item_depth
 * @property $imageFile
 */

namespace sirgalas\menu\entities;

use Yii;
use yii\db\ActiveRecord;
use sirgalas\menu\MenuModule;
use yii\data\ActiveDataProvider;
use sirgalas\menu\behaviors\MenuBaseWordpressBehavior;
use yii\helpers\Json;

class MenuItem extends ActiveRecord
{

    public $imageFile;

    public static function tableName()
    {

        return '{{%menu_item}}';

    }

    public function rules()
    {

        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 510],
            [['name_table_id', 'parent_id', 'item_depth'], 'integer'],
            ['content', 'safe'],
            [['imageFile'],'file','skipOnEmpty' => true,'extensions' => 'jpg, png']
        ];

    }

    public function attributeLabels()
    {

        return [
            'id' => 'id',
            'name' => MenuModule::t('translit', 'Name'),
            'parent_id' => MenuModule::t('translit', 'ParentId'),
            'name_table_id' => MenuModule::t('translit', 'Name_table_id'),
            'item_deptch' => MenuModule::t('translit', 'Item_deptch'),
            'content' => MenuModule::t('translit', 'Content')
        ];
    }

    public function allMenu($id){
        $menuItem= MenuItem::find()->where(['name_table_id'=>$id]);
        if(!$menuItem)
            return false;
        $serialDataProvider = new ActiveDataProvider([
            'query' => $menuItem,
            'pagination' => [
                'pageSize' => 24,
            ],
        ]);
            return $serialDataProvider;
    }
    

}
