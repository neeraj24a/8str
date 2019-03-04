<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-4 col-sm-6 ml-auto mr-auto">
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form','autocomplete' => 'off'],
    ]);
    ?>
        <div class="card card-login">
            <div class="card-header card-header-rose text-center">
                <h4 class="card-title">Log in</h4>
            </div>
            <div class="card-body ">
                <span class="bmd-form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">email</i>
                            </span>
                        </div>
                        <?php echo $form->field($model, 'username')->textInput(['class' => 'form-control', 'placeholder' => 'Username','autocomplete' => 'off']); ?>
                    </div>
                </span>
                <span class="bmd-form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                            </span>
                        </div>
                        <?php echo $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => 'Password','autocomplete' => 'off']); ?>
                    </div>
                </span>
            </div>
            <div class="card-footer justify-content-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-rose btn-link btn-lg', 'name' => 'login-button']) ?> | 
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>