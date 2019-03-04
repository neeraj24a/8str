<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	if($model->type == 'audio')
		$this->title = "8thwonderpromos Audio Drops: ".$model->title;
	else
		$this->title = "8thwonderpromos Video Drops: ".$model->title;
?>
<section class="banner-area top-breadcrumbs">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>DJ Drops</h1>
            </div>
            <div class="col-second">
                <p><?php echo $model->title; ?></p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="<?php echo Url::toRoute('/djdrops'); ?>">DJ Drops<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Drop Detail</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="holder">
	<div class="container">
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
			<?php if($model->type == 'video' && $model->youtube != ''): ?>
				<div class="video-container">
					<iframe width="853" height="480" src="https://www.youtube.com/embed/<?php echo getUtubeId($model->youtube); ?>" frameborder="0" allowfullscreen></iframe>
				</div>
			<?php else: ?>
				<div class="col-lg-2">&nbsp;</div>
				<div class="col-lg-8">
					<img class="img-responsive" src="<?php echo Url::toRoute('/images/audio-drop.png'); ?>">
					<?php 
						$src = str_replace('../', Yii::$app->homeUrl, $model->file);  
					?>
					<div class="audio-player">
						<audio preload="auto" controls>
							<source src="<?php echo $src; ?>">
						</audio>
					</div>	
				</div>
				<div class="col-lg-2">&nbsp;</div>
			<?php endif; ?>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12">
				<h3><?php echo $model->title; ?></h3>	
			</div>
			<div class="col-lg-12">
				<p>Price: $<?php echo $model->price; ?></p>
			</div>
			<div class="col-lg-12">
				<?php echo $model->description; ?>
			</div>
			<?php if($inCart): ?>
				<?php $form = ActiveForm::begin(['action' => ['cart/remove'],'options' => ['method' => 'post','id' => 'drop-to-cart']]) ?>
				<div class="col-lg-12">
	                <div class="form-group">
	                    <?= $form->field($cartForm, 'type')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => 'drop', 'name' => 'type'])->label(false); ?>
	                    <?= $form->field($cartForm, 'product')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => $model->slug, 'name' => 'product'])->label(false); ?>
	                </div>
	            </div>
	            <div class="col-lg-12 m-t-20">
	                <?= Html::submitButton('Remove From Cart', ['class' => 'btn btn-success']) ?>
	            </div>
				<?php ActiveForm::end(); ?>
			<?php else: ?>
				<?php $form = ActiveForm::begin(['action' => ['cart/add'],'options' => ['method' => 'post','id' => 'drop-to-cart']]) ?>
				<div class="col-lg-12">
	                <div class="form-group">
	                    <?= $form->field($cartForm, 'desc')->textarea(['maxlength' => true,'class' => 'form-control', 'name' => 'description']); ?>
	                    <?= $form->field($cartForm, 'type')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => 'drop', 'name' => 'type'])->label(false); ?>
	                    <?= $form->field($cartForm, 'quantity')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => '1', 'name' => 'quantity'])->label(false); ?>
	                    <?= $form->field($cartForm, 'product')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => $model->slug, 'name' => 'product'])->label(false); ?>
	                </div>
	            </div>
	            <div class="col-lg-12 m-t-20">
	                <?= Html::submitButton('Add To Cart', ['class' => 'btn btn-success']) ?>
	            </div>
				<?php ActiveForm::end(); ?>
			<?php endif; ?>
			<div class="col-lg-12">
				<div class="alert alert-success" style="display: none;">
				  	
				</div>
				<div class="alert alert-warning" style="display: none;">
				  	
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$this->registerJs(
    "(function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
    $(document).ready(function(){
    	$( 'audio' ).audioPlayer();
        $('#drop-to-cart').on('beforeSubmit', function(e){
        	e.preventDefault();
    		var form = $(this);
	      	$.ajax({
	            url    : form.attr('action'),
	            type   : 'POST',
	            data   : form.serialize(),
	            success: function (response) 
	            {                  
	               	console.log(response);
	               	var res = $.parseJSON(response);
	               	if(res.msg == 'Added'){
	               		$('.alert-warning').html('').hide();
	               		$('.alert-success').html('<strong>Drop</strong> Added To Cart Successfully !').show();
	               	} else if(res.msg == 'Already Added') {
	               		$('.alert-success').html('').hide();
	               		$('.alert-warning').html('<strong>Drop</strong> Already Present In Cart !').show();
               		} else if(res.msg == 'Removed') {
               			$('.alert-warning').html('').hide();
               			$('.alert-success').html('<strong>Drop</strong> Removed From Cart !').show();
               		}
	            },
	            error  : function (e) 
	            {
	                console.log(e);
	            }
	        });
		    return false;
        }).on('submit', function(e){
		    e.preventDefault();
		});
    });"
);
?>