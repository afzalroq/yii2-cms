<?php

namespace afzalroq\cms\forms;

use afzalroq\cms\entities\Entities;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use afzalroq\cms\entities\Items;

/**
 * ItemsSearch represents the model behind the search form of `afzalroq\cms\entities\Items`.
 */
class ItemsSearch extends Items
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_id', 'date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'text_1_0', 'text_1_1', 'text_1_2', 'text_1_3', 'text_1_4', 'text_2_0', 'text_2_1', 'text_2_2', 'text_2_3', 'text_2_4', 'text_3_0', 'text_3_1', 'text_3_2', 'text_3_3', 'text_3_4', 'text_4_0', 'text_4_1', 'text_4_2', 'text_4_3', 'text_4_4', 'text_5_0', 'text_5_1', 'text_5_2', 'text_5_3', 'text_5_4', 'text_6_0', 'text_6_1', 'text_6_2', 'text_6_3', 'text_6_4', 'text_7_0', 'text_7_1', 'text_7_2', 'text_7_3', 'text_7_4', 'file_1_0', 'file_1_1', 'file_1_2', 'file_1_3', 'file_1_4', 'file_2_0', 'file_2_1', 'file_2_2', 'file_2_3', 'file_2_4', 'file_3_0', 'file_3_1', 'file_3_2', 'file_3_3', 'file_3_4'], 'safe'],
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
    public function search($params, $slug)
    {
        $entites = Entities::findOne(['slug' => $slug]);
        $query = Items::find()->where(['entity_id' => $entites->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
            'entity_id' => $this->entity_id,
            'date' => $this->date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'text_1_0', $this->text_1_0])
            ->andFilterWhere(['like', 'text_1_1', $this->text_1_1])
            ->andFilterWhere(['like', 'text_1_2', $this->text_1_2])
            ->andFilterWhere(['like', 'text_1_3', $this->text_1_3])
            ->andFilterWhere(['like', 'text_1_4', $this->text_1_4])
            ->andFilterWhere(['like', 'text_2_0', $this->text_2_0])
            ->andFilterWhere(['like', 'text_2_1', $this->text_2_1])
            ->andFilterWhere(['like', 'text_2_2', $this->text_2_2])
            ->andFilterWhere(['like', 'text_2_3', $this->text_2_3])
            ->andFilterWhere(['like', 'text_2_4', $this->text_2_4])
            ->andFilterWhere(['like', 'text_3_0', $this->text_3_0])
            ->andFilterWhere(['like', 'text_3_1', $this->text_3_1])
            ->andFilterWhere(['like', 'text_3_2', $this->text_3_2])
            ->andFilterWhere(['like', 'text_3_3', $this->text_3_3])
            ->andFilterWhere(['like', 'text_3_4', $this->text_3_4])
            ->andFilterWhere(['like', 'text_4_0', $this->text_4_0])
            ->andFilterWhere(['like', 'text_4_1', $this->text_4_1])
            ->andFilterWhere(['like', 'text_4_2', $this->text_4_2])
            ->andFilterWhere(['like', 'text_4_3', $this->text_4_3])
            ->andFilterWhere(['like', 'text_4_4', $this->text_4_4])
            ->andFilterWhere(['like', 'text_5_0', $this->text_5_0])
            ->andFilterWhere(['like', 'text_5_1', $this->text_5_1])
            ->andFilterWhere(['like', 'text_5_2', $this->text_5_2])
            ->andFilterWhere(['like', 'text_5_3', $this->text_5_3])
            ->andFilterWhere(['like', 'text_5_4', $this->text_5_4])
            ->andFilterWhere(['like', 'text_6_0', $this->text_6_0])
            ->andFilterWhere(['like', 'text_6_1', $this->text_6_1])
            ->andFilterWhere(['like', 'text_6_2', $this->text_6_2])
            ->andFilterWhere(['like', 'text_6_3', $this->text_6_3])
            ->andFilterWhere(['like', 'text_6_4', $this->text_6_4])
            ->andFilterWhere(['like', 'text_7_0', $this->text_7_0])
            ->andFilterWhere(['like', 'text_7_1', $this->text_7_1])
            ->andFilterWhere(['like', 'text_7_2', $this->text_7_2])
            ->andFilterWhere(['like', 'text_7_3', $this->text_7_3])
            ->andFilterWhere(['like', 'text_7_4', $this->text_7_4])
            ->andFilterWhere(['like', 'file_1_0', $this->file_1_0])
            ->andFilterWhere(['like', 'file_1_1', $this->file_1_1])
            ->andFilterWhere(['like', 'file_1_2', $this->file_1_2])
            ->andFilterWhere(['like', 'file_1_3', $this->file_1_3])
            ->andFilterWhere(['like', 'file_1_4', $this->file_1_4])
            ->andFilterWhere(['like', 'file_2_0', $this->file_2_0])
            ->andFilterWhere(['like', 'file_2_1', $this->file_2_1])
            ->andFilterWhere(['like', 'file_2_2', $this->file_2_2])
            ->andFilterWhere(['like', 'file_2_3', $this->file_2_3])
            ->andFilterWhere(['like', 'file_2_4', $this->file_2_4])
            ->andFilterWhere(['like', 'file_3_0', $this->file_3_0])
            ->andFilterWhere(['like', 'file_3_1', $this->file_3_1])
            ->andFilterWhere(['like', 'file_3_2', $this->file_3_2])
            ->andFilterWhere(['like', 'file_3_3', $this->file_3_3])
            ->andFilterWhere(['like', 'file_3_4', $this->file_3_4]);

        return $dataProvider;
    }
}
