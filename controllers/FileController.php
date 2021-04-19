<?php

namespace afzalroq\cms\controllers;

use yii\web\Controller;

/**
 * CollectionsController implements the CRUD actions for Collections model.
 */
class FileController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
