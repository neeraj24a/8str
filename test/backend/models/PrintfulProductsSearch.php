<?php

namespace backend\models; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use backend\models\PrintfulProducts; 

/** 
 * PrintfulProductsSearch represents the model behind the search form of `backend\models\PrintfulProducts`.
 */ 
class PrintfulProductsSearch extends PrintfulProducts 
{ 
    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [ 
            [['id', 'printful_product_name', 'status', 'deleted', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'safe'], 
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
        $query = PrintfulProducts::find(); 

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
            'date_entered' => $this->date_entered,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'printful_product_name', $this->printful_product_name])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'deleted', $this->deleted])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider; 
    } 
} 