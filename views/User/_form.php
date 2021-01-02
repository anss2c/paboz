<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
        " 
       
        $('#form-calk').on('beforeSubmit', function(e) { 
            var form = $(this);
            var formData = form.serialize();
            $.ajax({ 
                url: form.attr('action'),
                type: 'post' ,
                data: {username : $('#username').val(), password_hash: $('#password_hash').val(), email : $('#email').val()},
                success: function (data) {
                    if (data=='true') {   
                        return true;                                         
                    } else {

                        alert(data);
                    };
                },

                });
            }).on('submit', function(e){
                e.preventDefault();
        });",
    \yii\web\View::POS_READY
//    //'my-button-handler'
);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-calk', 'enableClientValidation' => true, 'enableAjaxValidation' => false,
    'action' => ['site/signup'],
    'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'id' => 'username']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'id' => 'email']) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'id' => 'password_hash']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', ['/site/login']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
