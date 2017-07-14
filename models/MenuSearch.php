<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.05.17
 * Time: 16:40
 */

namespace sirgalas\menu\models;

use sirgalas\menu\models\Menu;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class MenuSearch extends Menu
{
    public $name;
    public function rules()
    {
        $module=\Yii::$app->controller->module;

        if(isset(Yii::$app->modules['menu']->modelDb)){
            $menuModel=Yii::$app->modules['menu']->modelDb;
            $menuSetup=new $menuModel;
            return[
                [[$menuSetup->getName()],'safe'],
            ];
        }else{
            return [
                [['name'], 'safe'],
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
            // bypass scenarios() implementation in the parent class
            return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(isset(Yii::$app->modules['menu']->modelDb)) {
            $menuModel = Yii::$app->modules['menu']->modelDb;
            $menuSetup=new $menuModel;
            $query = $menuModel::find()->where([$menuSetup->getServiceField()=>$menuSetup->getNameServiceField()]);
        }else{
            $query = Menu::find();
        }

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        
        return $dataProvider;
    }
}