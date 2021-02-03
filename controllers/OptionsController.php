<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\controllers\actions\CmsNodeMoveAction;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\Options;
use afzalroq\cms\forms\OptionsSearch;
use richardfan\sortable\SortableAction;
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'nodeMove' => [
                'class' => CmsNodeMoveAction::class,
                'modelName' => Options::class,
            ],
            'sortItem' => [
                'class' => SortableAction::class,
                'activeRecordClassName' => Options::class,
                'orderColumn' => 'sort',
                'startPosition' => 1, // optional, default is 0
            ],
            // your other actions
        ];
    }

    /**
     * Lists all Options models.
     *
     * @param string $slug
     * @return mixed
     */
    public function actionIndex($slug)
    {
        $collection = Collections::findOne(['slug' => $slug]);

        if ($collection->use_parenting)
            return $this->render('index_nestable', [
                'collection' => $collection
            ]);

        $searchModel = new OptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'collection' => $collection
        ]);
    }

    /**
     * Displays a single Options model.
     *
     * @param integer $id
     * @param string $slug
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
        $collection = Collections::findOne(['slug' => $slug]);
        $model->parentCollection = $collection;

        if ($model->load(Yii::$app->request->post()) && $model->appendTo(Options::findOne(['collection_id' => $collection->id, 'depth' => 0])))
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);

        return $this->render('create', [
            'model' => $model,
            'collection' => $collection
        ]);
    }

    public function actionAddChild($root_id, $slug)
    {
        $model = new Options();
        $collection = Collections::findOne(['slug' => $slug]);
        $model->parentCollection = $collection;

        if ($model->load(Yii::$app->request->post()) && $model->appendTo(Options::findOne($root_id)))
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);

        return $this->render('add-child', [
            'model' => $model,
            'root_id' => $root_id,
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
