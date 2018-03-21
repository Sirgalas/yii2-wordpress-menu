<?php
namespace sirgalas\menu\search;

use sirgalas\menu\entities\MenuName;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class MenuSearch extends MenuName
{
    public $name;
    public function rules()
    {

            return [
                [['name'], 'safe'],
            ];
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

        $query = MenuName::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}