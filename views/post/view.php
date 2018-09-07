<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $comment app\models\Comment */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content',
            'status',
            'tags',
        ],
    ]) ?>

    <div id="comments">
        <?php if($model->commentCount() >= 1): ?>
        <h3>
            <?php echo $model->commentCount()>1 ? $model->commentCount() . ' comments' : 'One comment'; ?>
        </h3>

        <?= $this->render('_comments',[
            'model'=>$model,
            'comments'=>$model->comments,
            ]); ?>


        <?php endif; ?>

     <h3>Leave a Comment</h3>

        <?php
        $comment = new \app\models\Comment();
        if(Yii::$app->session->hasFlash('commentSubmitted')): ?>
            <div class="flash-success">
                <?php echo Yii::$app->session->getFlash('commentSubmitted'); ?>
            </div>
        <?php else: ?>
            <?= $this->render('/comment/_form',[
                'model'=> $comment,
            ]); ?>
        <?php endif; ?>

    </div><!-- comments -->