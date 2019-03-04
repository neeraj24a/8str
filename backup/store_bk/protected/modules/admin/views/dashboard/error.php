<section class="content-header">
  <h1>
    Error <?php echo $code; ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url().'/school'; ?>"><i class="fa fa-dashboard"></i> School</a></li>
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Error</a></li>
  </ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Error <?php echo $code; ?></h3>
				</div>
				<div class="box-body">
					<?php echo CHtml::encode($message); ?>
				</div>
				<div class="box-footer">
				<?php if(!Yii::app()->user->id): ?>
					<a href="<?php echo base_url(); ?>/school">Back To Login</a>
				<?php else: ?>
					<a href="<?php echo base_url(); ?>/school">Back To Dashboard</a>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>