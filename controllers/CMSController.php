<?php

namespace afzalroq\cms\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CMSController extends Controller
{
    public function afterAction($action, $result)
    {
        if ($result = parent::afterAction($action, $result)) {
            return $result;
        }
        throw new NotFoundHttpException(\Yii::t('cms', 'The requested page does not exist.'));
    }
}
