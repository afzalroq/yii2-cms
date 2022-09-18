<?php

namespace afzalroq\cms\forms;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OptionsSearch extends Options
{
    public function rules()
    {
        return [
            [['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4'], 'safe'],
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
     * @param string $slug
     *
     * @return ActiveDataProvider
     */
    public function search($params, $slug)
    {
        $query = Options::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC
                ]
            ],
        ]);

        $this->load($params);

        $this->detachBehavior('slug');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name_0', $this->name_0])
            ->andFilterWhere(['like', 'name_1', $this->name_1])
            ->andFilterWhere(['like', 'name_2', $this->name_2])
            ->andFilterWhere(['like', 'name_3', $this->name_3])
            ->andFilterWhere(['like', 'name_4', $this->name_4]);

        return $dataProvider;
    }
}
