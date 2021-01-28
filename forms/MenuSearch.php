<?php

namespace afzalroq\cms\forms;

use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MenuSearch represents the model behind the search form of `Menu`.
 */
class MenuSearch extends Menu
{

    public function rules()
    {
        return [
            [['id', 'type', 'type_helper', 'created_at',], 'integer'],
            [['title_0'], 'safe'],
        ];
    }


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
    public function search($params, $slug)
    {
        $query = Menu::find()->where(['menu_type_id' => MenuType::findOne(['slug' => $slug])->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title_0', $this->title_0]);

        return $dataProvider;
    }
}
