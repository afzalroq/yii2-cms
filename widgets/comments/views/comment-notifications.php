<?php use yii\helpers\Url;

if($count > 0): ?>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-comment"></i>
        <span class="label label-warning"><?=$count?></span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have <?=$count?> notifications from comments</li>
        <li>
            <ul class="menu">
                <?php foreach ($notifications as $notification) : ?>
                    <li>
                        <a href="<?=Url::to(['/cms/items/view', 'id' => $notification['id'], 'slug' => $notification['entity']['slug']])?>#comments-section">
                            <?=$notification['text_1_0']?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </li>
    </ul>
<?php endif?>

