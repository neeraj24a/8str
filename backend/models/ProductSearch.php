<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Products;

/**
 * ProductSearch represents the model behind the search form of `backend\models\Products`.
 */
class ProductSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'printful_product', 'sku', 'slug', 'name', 'description', 'category', 'unit_price', 'offer_price', 'variation', 'size', 'colors', 'weight_type', 'weight', 'available', 'is_synced', 'printful_id', 'external_id', 'discount', 'main_image', 'is_featured', 'status', 'deleted', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'safe'],
            [['units_in_stock'], 'integer'],
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
        $query = Products::find();

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
            'units_in_stock' => $this->units_in_stock,
            'date_entered' => $this->date_entered,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['printful_product', 'printful_product', $this->id])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'unit_price', $this->unit_price])
            ->andFilterWhere(['like', 'offer_price', $this->offer_price])
            ->andFilterWhere(['like', 'variation', $this->variation])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'colors', $this->colors])
            ->andFilterWhere(['like', 'weight_type', $this->weight_type])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'available', $this->available])
            ->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'main_image', $this->main_image])
            ->andFilterWhere(['like', 'is_featured', $this->is_featured])
            ->andFilterWhere(['like', 'is_synced', $this->is_synced])
            ->andFilterWhere(['like', 'printful_id', $this->printful_id])
            ->andFilterWhere(['like', 'external_id', $this->external_id])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'deleted', $this->deleted])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}
