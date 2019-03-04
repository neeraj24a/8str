<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Orders;

/**
 * OrderSearch represents the model behind the search form of `backend\models\Orders`.
 */
class OrderSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer', 'order_number', 'order_amount', 'payment_method', 'transaction_id', 'payment_status', 'order_date', 'shipping_date', 'is_paid', 'freight', 'note', 'shipping_method', 'is_shipped', 'shipping_tracking', 'shipping_address', 'billing_address', 'status', 'deleted', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'safe'],
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
        $query = Orders::find();

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
            'order_date' => $this->order_date,
            'shipping_date' => $this->shipping_date,
            'date_entered' => $this->date_entered,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'customer', $this->customer])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'order_amount', $this->order_amount])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'payment_status', $this->payment_status])
            ->andFilterWhere(['like', 'is_paid', $this->is_paid])
            ->andFilterWhere(['like', 'freight', $this->freight])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'shipping_method', $this->shipping_method])
            ->andFilterWhere(['like', 'is_shipped', $this->is_shipped])
            ->andFilterWhere(['like', 'shipping_tracking', $this->shipping_tracking])
            ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
            ->andFilterWhere(['like', 'billing_address', $this->billing_address])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'deleted', $this->deleted])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}
