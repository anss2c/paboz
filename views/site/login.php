<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
        " 
       
        $('#login-form').on('beforeSubmit', function(e) { 
            var form = $(this);
            var formData = form.serialize();
            $.ajax({ 
                url: form.attr('action'),
                type: 'post' ,
                data: {username : $('#username').val(), password_hash: $('#password_hash').val()},
                success: function (data) {
                   
                },

                });
            }).on('submit', function(e){
                e.preventDefault();
        });",
    \yii\web\View::POS_READY
//    //'my-button-handler'
);
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'action' => ['site/login'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'maxlength' => true, 'id' => 'username']) ?>

        <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'id' => 'password_hash']) ?>

        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('Sign Up', ['/site/signup'], ['class'=>'btn btn-success']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/12345</strong> 
    </div>
</div>
