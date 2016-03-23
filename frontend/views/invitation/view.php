<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Invitation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Invitations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invitation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:ntext',
            'email:ntext',
            'sent_date',
            'registration_date',
            'date_of_last_sign_in',
            'status:ntext',
            'id_user',
        ],
    ]) ?>

</div>
