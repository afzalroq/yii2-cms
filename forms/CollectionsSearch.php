<?php

namespace afzalroq\cms\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use afzalroq\cms\entities\Collections;

/**
 * CollectionsSearch represents the model behind the search form of `abdualiym\cms\entities\Collections`.
 */
class CollectionsSearch extends Collections
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'use_in_menu', 'use_parenting', 'option_file_1', 'option_file_2', 'option_name', 'option_content', 'option_default_id', 'created_at', 'updated_at'], 'integer'],
            [['name_0', 'name_1', 'name_2', 'name_3', 'name_4', 'slug', 'option_file_1_label', 'option_file_2_label', 'option_file_1_validator', 'option_file_2_validator'], 'safe'],
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
        $query = Collections::find();

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
            'use_in_menu' => $this->use_in_menu,
            'use_parenting' => $this->use_parenting,
            'option_file_1' => $this->option_file_1,
            'option_file_2' => $this->option_file_2,
            'option_name' => $this->option_name,
            'option_content' => $this->option_content,
            'option_default_id' => $this->option_default_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_0', $this->name_0])
            ->andFilterWhere(['like', 'name_1', $this->name_1])
            ->andFilterWhere(['like', 'name_2', $this->name_2])
            ->andFilterWhere(['like', 'name_3', $this->name_3])
            ->andFilterWhere(['like', 'name_4', $this->name_4])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'option_file_1_label', $this->option_file_1_label])
            ->andFilterWhere(['like', 'option_file_2_label', $this->option_file_2_label])
            ->andFilterWhere(['like', 'option_file_1_validator', $this->option_file_1_validator])
            ->andFilterWhere(['like', 'option_file_2_validator', $this->option_file_2_validator]);

        return $dataProvider;
    }
}
