<?php

namespace backend\models; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use backend\models\PrintfulProductDetails; 

/** 
 * PrintfulProductsSearch represents the model behind the search form of `backend\models\PrintfulProducts`.
 */ 
class PrintfulProductDetailsSearch extends PrintfulProductDetails
{ 
    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [ 
            [['id', 'printful_product', 'color', 'size', 'status', 'deleted', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'safe'],
            [['printful_product_id'], 'integer'], 
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
        $query = PrintfulProductDetails::find(); 

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
            'printful_product_id' => $this->printful_product_id,
            'date_entered' => $this->date_entered,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'printful_product', $this->printful_product])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'deleted', $this->deleted])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider; 
    } 
} 