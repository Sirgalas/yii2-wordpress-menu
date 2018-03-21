<?php

/**
 * @property integer $id
 * @property  string $name
 * @property integer $parent_id
 * @property data $created_at
 * @property data $updated_at
 */

namespace sirgalas\menu\entities;

use Yii;
use yii\db\ActiveRecord;
use sirgalas\menu\MenuModule;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
class MenuName extends ActiveRecord
{

    public $imageFile;
    public static function tableName()
    {

            return '{{%menu_name}}';

    }

    public function behaviors()
    {
        return [
            'timestamp'=>[
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {

            return [
                [['name'], 'required'],
                [['name'], 'string', 'max' => 510],
                [['name'], 'unique'],
                ['parent_id','integer'],
                [['created_at','updated_at'],'safe']
            ];

    }
    public function attributeLabels()
    {

            $returnArray = array([
                'id' => 'id',
                'name' => MenuModule::t('translit', 'Name'),
                'parent_id' => MenuModule::t('translit', 'ParentId'),
                'created_at'=>MenuModule::t('translit','Created_at'),
                'updated_at'=>MenuModule::t('translit','Updated_at'),
            ]);

        return $returnArray;
    }
   
}
