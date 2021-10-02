<?php

namespace afzalroq\cms\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CController extends Controller
{
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if($result == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }else{
            return $result;
        }
    }
}
