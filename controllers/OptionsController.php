<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use afzalroq\cms\forms\OptionsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OptionsController implements the CRUD actions for Options model.
 */
class OptionsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Options models.
     *
     * @return mixed
     */
    public function actionIndex($slug)
    {
        $searchModel = new OptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'collection' => Collections::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Displays a single Options model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'collection' => Collections::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Finds the Options model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Options the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Options::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Options model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($slug)
    {
        $model = new Options();
        $model->parentCollection = Collections::findOne(['slug' => $slug]);

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);

        return $this->render('create', [
            'model' => $model,
            'collection' => Collections::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Updates an existing Options model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $slug)
    {
        $model = $this->findModel($id);
        $model->parentCollection = Collections::findOne(['slug' => $slug]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);
        }

        return $this->render('update', [
            'model' => $model,
            'collection' => Collections::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Deletes an existing Options model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $slug)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'slug' => $slug]);
    }
}
