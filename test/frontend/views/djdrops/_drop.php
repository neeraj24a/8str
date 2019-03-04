<?php
use yii\helpers\Url;
	if($model->youtube != '' && $model->type == 'video'):
		$video_id = getUtubeId($model->youtube);
?>
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 tile">
	<div class="col-lg-12">
		<a href="<?php echo Url::toRoute('/djdrops/details?drop='.$model->slug); ?>">
			<img class="img-responsive" src="https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg">
		</a>
	</div>
	<div class="col-lg-12">
		<h3>
			<a href="<?php echo Url::toRoute('/djdrops/details?drop='.$model->slug); ?>"><?php echo $model->title; ?><a/>
			$<?php echo $model->price; ?>
		</h3>
	</div>
</div>
<?php else: ?>
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 tile">
	<div class="col-lg-12">
		<a href="<?php echo Url::toRoute('/djdrops/details?drop='.$model->slug); ?>">
			<img class="img-responsive audio" src="<?php echo Url::toRoute('/images/audio-drop.png'); ?>">
		</a>
	</div>
	<div class="col-lg-12">
		<h3>
			<a href="<?php echo Url::toRoute('/djdrops/details?drop='.$model->slug); ?>"><?php echo $model->title; ?><a/>
			$<?php echo $model->price; ?>
		</h3>
	</div>
</div>
<?php endif; ?>