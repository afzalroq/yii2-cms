<?php

use abdualiym\language\Language;

$url = Yii::$app->language;

foreach ($menu as $key => $value) : ?>
    <?php $parent = isset($value['childs']) && $value['childs']; ?>
    <li <?= $parent ? 'class="dropdown"' : '' ?>>
        <a href="<?= $value['link'] ?>" <?= $parent ? 'class="dropdown-toggle" data-toggle="dropdown"' : '' ?>>
            <?= Language::getAttribute($value, 'title', $url) ?> <?= $parent ? ' <b class="caret"></b>' : '' ?>
        </a>
        <?php if ($parent): ?>
            <ul class="dropdown-menu">
                <?php foreach ($value['childs'] as $key => $childValue) : ?>
                    <?php if (isset($childValue['childs']) && $childValue['childs']) : ?>
                        <li class="dropdown">
                            <a href="<?= $childValue['link'] ?>" class="dropdown-toggle" data-toggle="dropdown">
                                <?= Language::getAttribute($childValue, 'title', $url) ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($childValue['childs'] as $key => $children) : ?>
                                    <li><a href="<?= $children['link'] ?>"><?= Language::getAttribute($children, 'title', $url) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= $childValue['link'] ?>"><?= Language::getAttribute($childValue, 'title', $url) ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
