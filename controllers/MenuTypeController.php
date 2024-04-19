<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\CaM;
use afzalroq\cms\entities\MenuType;
use afzalroq\cms\entities\Options;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MenuTypeController implements the CRUD actions for MenuType model.
 */
class MenuTypeController extends Controller
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

    public function actionDeleteOptions($id, $camId)
    {
        $this->findModelCaM($camId)->delete();

        return $this->redirect(['view', 'id' => $id]);
    }

    protected function findModelCaM($id)
    {
        if (($model = CaM::findOne(['menu_type_id' => $id])) !== null) {
            return $model;
        }
    }

    public function actionUpdateOptions($id, $camId)
    {

        $model = $this->findModel($id);
        $cam = $this->findModelCaM($camId);

        if ($cam->load(Yii::$app->request->post()) && $cam->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('cam/update', [
            'model' => $model,
            'cam' => $cam,
        ]);
    }

    /**
     * Finds the MenuType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    public function actionAddOptions($id)
    {
        $model = $this->findModel($id);
        $cam = new CaM();

        if ($cam->load(Yii::$app->request->post()) && $cam->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('cam/create', [
            'model' => $model,
            'cam' => $cam,
        ]);
    }

    public function actionOptionsList()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->get('collectionId');
            $menuType = Yii::$app->request->get('menuType');
            $data = [];
            $optionsList = CaM::find()
                ->where(['menu_type_id' => $menuType])
                ->joinWith(['option' => function (ActiveQuery $query) use ($id) {
                    return $query->where(['collection_id' => $id]);
                }])
                ->select('option_id')
                ->column();
            if (!empty($optionsList)) {
                $options = Options::find()->where(['collection_id' => $id])->andWhere(['>', 'depth', 0])->andWhere(['not in', 'id', $optionsList])->all();
            } else {
                $options = Options::find()->where(['collection_id' => $id])->andWhere(['>', 'depth', 0])->all();
            }

            foreach ($options as $option) {
                $data[] = [
                    'id' => $option->id,
                    'name' => $option->{'name_' . Yii::$app->params['l'][Yii::$app->language]}
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
     * Lists all MenuType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MenuType::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'cam' => $this->findModelCaM($id)
        ]);
    }

    /**
     * Creates a new MenuType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuType();

        if ($model->load(Yii::$app->request->post()) && $model->add())
            return $this->redirect(['view', 'id' => $model->id]);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
