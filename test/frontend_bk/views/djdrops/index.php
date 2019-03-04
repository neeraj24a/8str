<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = "8thwonderpromos DJ Drops";
?>
<section class="banner-area top-breadcrumbs">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>DJ Drops</h1>
            </div>
            <div class="col-second">
                <p>DJ Audio Or Video Drops</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">DJ Drops</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="holder">
	<div class="container">
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['/djdrops']),
            'method' => 'get',
            'fieldConfig' => [
                'template' => "{input}",
            ],
        ]); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 filter">
            <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                <p>Filter: </p>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($searchModel, 'type')->dropDownList(['' => 'All','audio' => 'Audio','video' => 'Video'],['class' => 'form-control'])  ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($searchModel, 'title')->textInput(['class' => 'form-control'])  ?>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                <a href="<?php echo Url::to(['/djdrops']); ?>" class="btn btn-warning">Reset</a>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
		
		<?php
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_drop',
                'pager' => [
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'maxButtonCount' => 3,
                ],
            ]);
        ?>
	</div>
</section>