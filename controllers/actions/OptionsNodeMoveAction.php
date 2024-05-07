<?php


namespace afzalroq\cms\controllers\actions;


use afzalroq\cms\entities\Collections;
use creocoder\nestedsets\NestedSetsBehavior;
use slatiusa\nestable\NestableBehavior;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

class OptionsNodeMoveAction extends Action
{
    /** @var string class to use to locate the supplied data ids */
    public $modelName;

    /** @var bool variable to support editing without possibility of creating a root elements */
    public $rootable = true;

    /** @vars string the attribute names of the model that hold these attributes */
    private $leftAttribute;
    private $rightAttribute;
    private $treeAttribute;
    private $depthAttribute;

    /**
     * Move a node (model) below the parent and in between left and right
     *
     * @param integer $id the primaryKey of the moved node
     * @param integer $lft the primaryKey of the node left of the moved node
     * @param integer $rgt the primaryKey of the node right to the moved node
     * @param integer $par the primaryKey of the parent of the moved node
     */
    public function run($id = 0, $lft = 0, $rgt = 0, $par = 0)
    {
        if (null == $this->modelName) {
            throw new InvalidConfigException("No 'modelName' supplied on action initialization.");
        }

        /* response will be in JSON format */
        Yii::$app->response->format = 'json';

        /* Locate the supplied model, left, right and parent models */
        /** @var $model \afzalroq\cms\entities\Options */
        $model = Yii::createObject(ActiveQuery::className(), [$this->modelName])->where(['id' => $id])->one();
        $model->parentCollection = Collections::findOne($model->collection_id);
        $lft = Yii::createObject(ActiveQuery::className(), [$this->modelName])->where(['id' => $lft])->one();
        $rgt = Yii::createObject(ActiveQuery::className(), [$this->modelName])->where(['id' => $rgt])->one();
        $par = Yii::createObject(ActiveQuery::className(), [$this->modelName])->where(['id' => $par])->one();

        /* Get attribute names from model behaviour config */
        foreach ($model->behaviors as $behavior) {
            if ($behavior instanceof NestedSetsBehavior) {
                $this->leftAttribute = $behavior->leftAttribute;
                $this->rightAttribute = $behavior->rightAttribute;
                $this->treeAttribute = $behavior->treeAttribute;
                $this->depthAttribute = $behavior->depthAttribute;
                break;
            }
        }

        /* attach our bahaviour to be able to call the moveNode() function of the NestedSetsBehavior */
        $model->attachBehavior('nestable', [
            'class' => NestableBehavior::className(),
            'leftAttribute' => $this->leftAttribute,
            'rightAttribute' => $this->rightAttribute,
            'treeAttribute' => $this->treeAttribute,
            'depthAttribute' => $this->depthAttribute,
        ]);

        /* Root/Append/Left/Right change */
        if ($this->rootable && $this->treeAttribute && is_null($par) && !$model->isRoot()) {
            $model->makeRoot();
        } else if (is_null($par)) {
            if (!is_null($rgt))
                $model->insertBefore($rgt);
            else if (!is_null($lft))
                $model->insertAfter($lft);
        } else {
            if (!is_null($rgt))
                $model->insertBefore($rgt);
            else if (!is_null($lft))
                $model->insertAfter($lft);
            else
                $model->appendTo($par);
        }

        /* report new position */
        return ['updated' => [
            'id' => $model->id,
            'depth' => $model->{$this->depthAttribute},
            'lft' => $model->{$this->leftAttribute},
            'rgt' => $model->{$this->rightAttribute},
        ]];
    }

}
