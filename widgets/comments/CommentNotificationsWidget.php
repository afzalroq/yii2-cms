<?php

namespace afzalroq\cms\widgets\comments;



use afzalroq\cms\entities\ItemComments;
use afzalroq\cms\entities\Items;

class CommentNotificationsWidget extends \yii\base\Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
        $notifications = Items::find()->join('INNER JOIN', 'cms_item_comments', 'cms_items.id=cms_item_comments.item_id')->with('entity')->andWhere(['cms_item_comments.status' => ItemComments::STATUS_DRAFT])->asArray()->all();
        $count = count($notifications);
        return $this->render('comment-notifications', [
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

}