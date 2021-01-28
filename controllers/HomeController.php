<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\MenuType;
use afzalroq\cms\entities\unit\Categories;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'collectionProvider' => new ActiveDataProvider(['query' => Collections::find()]),
            'entityProvider' => new ActiveDataProvider(['query' => Entities::find()]),
            'unitCategoryProvider' => new ActiveDataProvider(['query' => Categories::find()]),
            'menuTypeProvider' => new ActiveDataProvider(['query' => MenuType::find()])
        ]);
    }
}
