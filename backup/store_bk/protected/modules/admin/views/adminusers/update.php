<section class="content-header">
  <h1>
    Update
    <small>Admin User</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url() . '/admin/adminusers'; ?>"><i class="fa fa-dashboard"></i> Admin Users</a></li>
    <li class="active">Update</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $model->username; ?></h3>
				</div>
				<?php $this->renderPartial('_update', array('model'=>$model,'countries'=>$countries,'states'=>$states,'roles'=>$roles)); ?>
			</div>
		</div>
	</div>
</section>