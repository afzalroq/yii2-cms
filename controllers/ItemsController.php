<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Items;
use afzalroq\cms\forms\ItemsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
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
	 * Lists all Items models.
	 *
	 * @return mixed
	 */
	public function actionIndex($slug)
	{
		$searchModel = new ItemsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'entity' => Entities::findOne(['slug' => $slug])
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
			'model' => $this->findModel($id),
			'entity' => Entities::findOne(['slug' => $slug])
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
		if(($model = Items::findOne($id)) !== null) {
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

		if(Yii::$app->request->isAjax) {
			$model->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($model));
		}

		if($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($model->files as $file) {
                    $model->addPhoto($file);
                }

            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);
		}

		return $this->render('create', [
			'model' => $model,
			'entity' => Entities::findOne(['slug' => $slug])
		]);
	}

	/**
	 * Updates an existing Items model.
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

		if($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($model->files as $file) {
                $model->addPhoto($file);
            }
			return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);
		}

		return $this->render('update', [
			'model' => $model,
			'entity' => Entities::findOne(['slug' => $slug])
		]);
	}

	/**
	 * Deletes an existing Items model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

    public function actionDeletePhoto($id, $photo_id,$slug)
    {
        try {
            $this->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);
    }


    public function actionMovePhotoUp($id, $photo_id, $slug)
    {
        $this->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);

    }

    public function actionMovePhotoDown($id, $photo_id, $slug)
    {
        $this->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, 'slug' => $slug]);

    }
    public function movePhotoUp($id, $photoId): void
    {
        $model = $this->findModel($id);
        $model->movePhotoUp($photoId);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $model = $this->findModel($id);
        $model->movePhotoDown($photoId);
        $model->save();
    }

    public function removePhoto($id, $photoId): void
    {
        $model = $this->findModel($id);
        $model->removePhoto($photoId);
        $model->save();
    }
}
