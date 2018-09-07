<?php

use yii\helpers\Html;

/* @var $model app\models\Post */
/* @var $comments app\models\Comment */

foreach($comments as $comment): ?>
    <div class="comment" id="c<?php echo $comment->id; ?>">

        <?php echo Html::a("#{$comment->id}", $comment->getUrl($model), [
                'class'=>'cid',
                'title'=>'Permalink to this comment',
            ]
        ); ?>

    <div class="author">
        <?php echo $comment->authorLink; ?> says:
    </div>

    <div class="time">
        <?php echo date('F j, Y \a\t h:i a', strtotime($comment->create_time)); ?>
    </div>

    <div class="content">
            <?php echo nl2br(Html::encode($comment->content)); ?>
    </div>


    </div><!-- comment -->
<?php endforeach; ?>

