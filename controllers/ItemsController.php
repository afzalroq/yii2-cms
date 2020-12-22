<?php

namespace abdualiym\cms\controllers;

use abdualiym\cms\entities\Entities;
use abdualiym\cms\entities\Items;
use abdualiym\cms\forms\ItemsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
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
		$model = new Items();

		if(Yii::$app->request->isAjax) {
			$model->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($model));
		}


		if($model->load(Yii::$app->request->post()) && $model->save()) {
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
}
