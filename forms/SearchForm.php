<?php

namespace abdualiym\cms\forms;

use abdualiym\cms\entities\Text;
use abdualiym\cms\entities\TextTranslation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchForm extends Model
{
    public $search;

    public function rules()
    {
        return [
            [['search'], 'string', 'max' => 25],
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
        $query = TextTranslation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
//                ->orderBy('date DESC'),
        ,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query = $query->joinWith('text');

        $query
            ->orFilterWhere(['like', 'title', $this->search])
            ->orFilterWhere(['like', 'description', $this->search])
            ->orFilterWhere(['like', 'content', $this->search]);
//            ->orFilterWhere(['like', 'text_text_translations.title', $this->search])
//            ->orFilterWhere(['like', 'text_text_translations.description', $this->search])
//            ->orFilterWhere(['like', 'text_text_translations.content', $this->search]);

        return $dataProvider;
    }
}
