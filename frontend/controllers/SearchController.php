<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Category;
use yii\data\ActiveDataProvider;

class SearchController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        if (!isset($_GET['search'])) {
            $this->redirect(['/shop']);
        }
        $search = $_GET['search'];
        $cat = $_GET['category'];
        $c = NULL;
        if ($cat != "all") {
            $c = Category::findOne(['category' => $cat]);
        }
        $query = Products::find();
        if ($c == NULL) {
            $query->andFilterWhere(['like', 'name', $search]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
        } else {
            $query->andFilterWhere([
                'category' => $c->id,
            ]);
            $query->andFilterWhere(['like', 'name', $search]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
        }

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

}
