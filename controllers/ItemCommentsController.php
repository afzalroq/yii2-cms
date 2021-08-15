<?php

namespace afzalroq\cms\controllers;

use afzalroq\cms\cms\comment\CommentForm;
use afzalroq\cms\cms\comment\CommentService;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\front\Comments;
use afzalroq\cms\entities\ItemComments;
use afzalroq\cms\entities\Items;

class ItemCommentsController extends \yii\web\Controller
{
    public function actionAdd($item_id, $slug)
    {
        $entity = Entities::findOne(['slug' => $slug]);
        $item = Items::findOne(['id' => $item_id]);
        $form = new Comments($entity, $item);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->save();
            return $this->redirect(['items/view', 'id' => $item_id, 'slug' => $slug]);
        }

        return $this->render('create', [
            'model' => $form,
            'entity' => $entity,
            'item' => $item
        ]);
    }

    public function actionUpdate($id, $slug)
    {
        $entity = Entities::findOne(['slug' => $slug]);
        $form = $this->findModel($id);
        $item = Items::findOne($form->item_id);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->save();
            return $this->redirect(['view', 'id' => $form->id, 'slug' => $slug]);
        }

        return $this->render('update', [
            'model' => $form,
            'entity' => $entity,
            'item' => $item
        ]);
    }

    public function actionChange($id, $slug, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;
        $model->save();

        return $this->render('view', [
            'model' => $model,
            'entity' => Entities::findOne(['slug' => $slug]),
            'item' => $model->item
        ]);
    }

    public function actionReply($id, $slug)
    {
        $entity = Entities::findOne(['slug' => $slug]);
        $comment = $this->findModel($id);
        $item = Items::findOne($comment->item_id);
        $form = new Comments($entity, $item, $comment);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->save(false);
            return $this->redirect(['items/view', 'id' => $comment->item_id, 'slug' => $slug]);
        }

        return $this->render('reply', [
            'entity' => $entity,
            'item' => $item,
            'parent' => $comment,
            'model' => $form,
        ]);
    }

    public function actionView($id, $slug)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'entity' => Entities::findOne(['slug' => $slug]),
            'item' =>  Items::findOne($model->item_id)

        ]);
    }

    /**
     * Deletes an existing Notifications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $slug)
    {
        $model = $this->findModel($id);
        $item_id = $model->item_id;
        $model->delete();
        return $this->redirect(['items/view', 'id' => $item_id, 'slug' => $slug]);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ItemComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemComments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

}