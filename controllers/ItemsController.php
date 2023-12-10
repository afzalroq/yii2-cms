<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\front\Items;
use afzalroq\cms\entities\ItemComments;
use afzalroq\cms\forms\ItemsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ItemsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Items models.
     *
     * @return mixed
     */
    public function actionIndex($slug)
    {
        $entity       = Entities::findOne(['slug' => $slug]);
        $searchModel  = new ItemsSearch($entity);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'entity'       => $entity,
        ]);
    }

    /**
     * Displays a single Items model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $slug)
    {
        return $this->render('view', [
            'model'                => $this->findModel($id),
            'entity'               => Entities::findOne(['slug' => $slug]),
            'commentsDataProvider' => new \yii\data\ActiveDataProvider([
                'query' => ItemComments::find()->where(['item_id' => $id]),
            ]),
        ]);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($slug)
    {
        $model = new Items($slug);

        return $this->saveAction($model, $slug, 'create');
    }


    public function actionUpdate($id, $slug)
    {
        $model = $this->findModel($id);

        return $this->saveAction($model, $slug, 'update');
    }

    private function saveAction(\afzalroq\cms\entities\Items $model, string $slug, $view)
    {
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());

            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($model->load(Yii::$app->request->post())) {
            $operation = Yii::$app->request->post('save');
            if (in_array($operation, ['add-new', 'save-close', 'save'])) {
                if ($model->save()) {
                    foreach ($model->files as $file) {
                        $model->addPhoto($file);
                    }
                    Yii::$app->session->setFlash('success', Yii::t('cms', 'Saved'));
                    if ($operation === 'add-new') {
                        return $this->redirect(['create', 'slug' => $slug]);
                    }
                    if ($operation === 'save') {
                        return $this->redirect(['update', 'id' => $model->id, 'slug' => $slug]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', implode('\n', $model->getFirstErrors()));
                }
            }

            return $this->redirect(['index', 'slug' => $slug]);
        }

        return $this->render($view, [
            'model'  => $model,
            'entity' => Entities::findOne(['slug' => $slug]),
        ]);
    }

    public function actionDelete($id, $slug)
    {
        $model = $this->findModel($id);
        $model->delete();
        $model->removePhotos();

        return $this->redirect(['index', 'slug' => $slug]);
    }

    public function actionDeletePhoto($id, $photo_id, $slug)
    {
        try {
            $model = $this->findModel($id);
            $model->removePhoto($photo_id);
            $model->save();
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);
    }

    public function actionMovePhotoUp($id, $photo_id, $slug)
    {
        $model = $this->findModel($id);
        $model->movePhotoUp($photo_id);

        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);
    }

    public function actionMovePhotoDown($id, $photo_id, $slug)
    {
        $model = $this->findModel($id);
        $model->movePhotoDown($photo_id);
        $model->save();

        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);
    }

    public function actionRefreshCommentStats($id, $slug)
    {
        $model = $this->findModel($id);
        $model->calculateCommentsAndVotes();

        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);
    }
}