<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
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

    public function actions()
    {
        return [
            'nodeMove' => [
                'class' => 'slatiusa\nestable\NodeMoveAction',
                'modelName' => Menu::className(),
            ],
//            'sortItem' => [
//                'class' => SortableAction::className(),
//                'activeRecordClassName' => Menu::className(),
//                'orderColumn' => 'sort',
//                'startPosition' => 1, // optional, default is 0
//            ],
            // your other actions
        ];
    }

    public function actionType()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $type = Yii::$app->request->post('type');
            $data = [];
            switch ($type) {
                case 'collection':
                    /** @var Options $option */
                    foreach (Options::findAll(['collection_id' => $id]) as $option)
                        $data[] = [
                            'id' => $option->id,
                            'name' => $option->name_0
                        ];
                    break;
                case 'option':
                    foreach (OaI::findAll(['option_id' => $id]) as $oai)
                        $data[] = [
                            'id' => $oai->item_id,
                            'name' => $oai->item->text_1_0
                        ];
                    break;
                case 'entity':
                    foreach (Items::findAll(['entity_id' => $id]) as $item)
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

    public function actionIndex($slug)
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'menuType' => MenuType::findOne(['slug' => $slug])
        ]);
    }

    public function actionView($id, $slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'menuType' => MenuType::findOne(['slug' => $slug])
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    public function actionCreate($slug)
    {
        $model = new Menu();
        $menuType = MenuType::findOne(['slug' => $slug]);

        if ($model->load(Yii::$app->request->post()) && $model->appendTo(Menu::findOne(['menu_type_id' => $menuType->id, 'depth' => 0])))
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);

        return $this->render('create', [
            'model' => $model,
            'menuType' => $menuType
        ]);
    }

    public function actionAddChild($root_id, $slug)
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->appendTo(Menu::findOne($root_id)))
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);

        return $this->render('add-child', [
            'model' => $model,
            'root_id' => $root_id,
            'menuType' => MenuType::findOne(['slug' => $slug])
        ]);
    }

    public function actionUpdate($id, $slug)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);


        return $this->render('update', [
            'model' => $model,
            'menuType' => MenuType::findOne(['slug' => $slug])
        ]);
    }

    public function actionDelete($id, $slug)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'slug' => $slug]);
    }
}
