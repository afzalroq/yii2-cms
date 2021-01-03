<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\OaI;
use afzalroq\cms\entities\Options;
use afzalroq\cms\forms\MenuSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
					'type' => ['POST']
				],
			],
		];
	}

	public function actionType()
	{
		if(Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$id = Yii::$app->request->post('id');
			$type = Yii::$app->request->post('type');
			$data = [];
			switch($type) {
				case 'collection':
					/** @var Options $option */
					foreach(Options::findAll(['collection_id' => $id]) as $option)
						$data[] = [
							'id' => $option->id,
							'name' => $option->name_0
						];
					break;
				case 'option':
					foreach(OaI::findAll(['option_id' => $id]) as $oai)
						$data[] = [
							'id' => $oai->item_id,
							'name' => $oai->item->text_1_0
						];
					break;
				case 'entity':
					foreach(Items::findAll(['entity_id' => $id]) as $item)
						$data[] = [
							'id' => $item->id,
							'name' => $item->text_1_0
						];
					break;
				default:
					return [
						'status' => 0,
						'message' => 'not ok'
					];
			}
			return [
				'status' => 1,
				'data' => $data
			];
		}
		return false;
	}


	/**
	 * Lists all Menu models.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new MenuSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Menu model.
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
	 * Finds the Menu model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Menu the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Menu::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
	}

	/**
	 * Creates a new Menu model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Menu();

		if($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);

	}

	/**
	 * Updates an existing Menu model.
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
	 * Deletes an existing Menu model.
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
