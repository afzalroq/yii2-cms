<?php

namespace abdualiym\cms\controllers;

use abdualiym\cms\entities\CaE;
use abdualiym\cms\entities\Entities;
use abdualiym\cms\forms\EntitiesSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EntitiesController implements the CRUD actions for Entities model.
 */
class EntitiesController extends Controller
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


	public function actionDeleteCollections($id, $caeId)
	{
		$this->findModelCae($caeId)->delete();

		return $this->redirect(['view', 'id' => $id]);
	}

	public function actionUpdateCollections($id, $caeId)
	{

		$model = $this->findModel($id);
		$cae = $this->findModelCae($caeId);

		if($cae->load(Yii::$app->request->post()) && $cae->save()) {
			return $this->redirect(['view', 'id' => $id]);
		}

		return $this->render('cae/update', [
			'model' => $model,
			'cae' => $cae,
			'unassignedCollections' => $cae->getUnassignedCollections($model, $cae->collection_id)
		]);
	}

	public function actionAddCollections($id)
	{
		$model = $this->findModel($id);
		$cae = new CaE();

		if(!$cae->getUnassignedCollections($model)) {
			Yii::$app->session->setFlash('warning', 'There are not collections!');
			return $this->redirect(['view', 'id' => $id]);
		}

		if($cae->load(Yii::$app->request->post()) && $cae->save()) {
			return $this->redirect(['view', 'id' => $id]);
		}

		return $this->render('cae/create', [
			'model' => $model,
			'cae' => $cae,
			'unassignedCollections' => $cae->getUnassignedCollections($model)
		]);
	}


	/**
	 * Lists all Entities models.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new EntitiesSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Entities model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Entities model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Entities();

		if($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Entities model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Entities model.
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


	/**
	 * Finds the Entities model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Entities the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Entities::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
	}

	/**
	 * Finds the CaE model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return CaE the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModelCae($id)
	{
		if(($model = CaE::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
	}
}
