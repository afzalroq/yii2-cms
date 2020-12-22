<?php

namespace afzalroq\cms\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use afzalroq\cms\entities\Entities;

/**
 * EntitiesSearch represents the model behind the search form of `abdualiym\cms\entities\Entities`.
 */
class EntitiesSearch extends Entities
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'text_1', 'text_2', 'text_3', 'text_4', 'text_5', 'text_6', 'text_7', 'file_1', 'file_2', 'file_3', 'use_date', 'use_status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'text_1_label', 'text_2_label', 'text_3_label', 'text_4_label', 'text_5_label', 'text_6_label', 'text_7_label', 'file_1_label', 'file_2_label', 'file_3_label'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Entities::find();

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
            'text_1' => $this->text_1,
            'text_2' => $this->text_2,
            'text_3' => $this->text_3,
            'text_4' => $this->text_4,
            'text_5' => $this->text_5,
            'text_6' => $this->text_6,
            'text_7' => $this->text_7,
            'file_1' => $this->file_1,
            'file_2' => $this->file_2,
            'file_3' => $this->file_3,
            'use_date' => $this->use_date,
            'use_status' => $this->use_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'text_1_label', $this->text_1_label])
            ->andFilterWhere(['like', 'text_2_label', $this->text_2_label])
            ->andFilterWhere(['like', 'text_3_label', $this->text_3_label])
            ->andFilterWhere(['like', 'text_4_label', $this->text_4_label])
            ->andFilterWhere(['like', 'text_5_label', $this->text_5_label])
            ->andFilterWhere(['like', 'text_6_label', $this->text_6_label])
            ->andFilterWhere(['like', 'text_7_label', $this->text_7_label])
            ->andFilterWhere(['like', 'file_1_label', $this->file_1_label])
            ->andFilterWhere(['like', 'file_2_label', $this->file_2_label])
            ->andFilterWhere(['like', 'file_3_label', $this->file_3_label]);

        return $dataProvider;
    }
}
