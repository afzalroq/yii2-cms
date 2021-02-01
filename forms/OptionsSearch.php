<?php

namespace afzalroq\cms\forms;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OptionsSearch represents the model behind the search form of `afzalroq\cms\entities\Options`.
 */
class OptionsSearch extends Options
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'collection_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4', 'content_0', 'content_1', 'content_2', 'content_3', 'content_4', 'file_1_0', 'file_1_1', 'file_1_2', 'file_1_3', 'file_1_4', 'file_2_0', 'file_2_1', 'file_2_2', 'file_2_3', 'file_2_4'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string $slug
     *
     * @return ActiveDataProvider
     */
    public function search($params, $slug)
    {
        $query = Options::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC
                ]
            ],
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
            'collection_id' => $this->collection_id,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name_0', $this->name_0])
            ->andFilterWhere(['like', 'name_1', $this->name_1])
            ->andFilterWhere(['like', 'name_2', $this->name_2])
            ->andFilterWhere(['like', 'name_3', $this->name_3])
            ->andFilterWhere(['like', 'name_4', $this->name_4])
            ->andFilterWhere(['like', 'content_0', $this->content_0])
            ->andFilterWhere(['like', 'content_1', $this->content_1])
            ->andFilterWhere(['like', 'content_2', $this->content_2])
            ->andFilterWhere(['like', 'content_3', $this->content_3])
            ->andFilterWhere(['like', 'content_4', $this->content_4])
            ->andFilterWhere(['like', 'file_1_0', $this->file_1_0])
            ->andFilterWhere(['like', 'file_1_1', $this->file_1_1])
            ->andFilterWhere(['like', 'file_1_2', $this->file_1_2])
            ->andFilterWhere(['like', 'file_1_3', $this->file_1_3])
            ->andFilterWhere(['like', 'file_1_4', $this->file_1_4])
            ->andFilterWhere(['like', 'file_2_0', $this->file_2_0])
            ->andFilterWhere(['like', 'file_2_1', $this->file_2_1])
            ->andFilterWhere(['like', 'file_2_2', $this->file_2_2])
            ->andFilterWhere(['like', 'file_2_3', $this->file_2_3])
            ->andFilterWhere(['like', 'file_2_4', $this->file_2_4]);

        return $dataProvider;
    }
}
