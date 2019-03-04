<section class="content-header">
    <h1>
        Front User
    </h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="<?php echo base_url() . '/admin/adminusers'; ?>"><i class="fa fa-dashboard"></i> Front Users</a></li>
	    <li class="active">View</li>
	</ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $model->username; ?> 
                        <small>
                            <a href="<?php echo base_url() . '/admin/adminusers/update?id=' . $model->id; ?>">EDIT</a>
                        </small>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
                        if(empty($model->state_id)){
                        	$model->state_id = "No State Selected";
                        } else {
                        	$model->state_id = States::model()->findByPk($model->state_id)->name;
                        }
                        if(empty($model->country_id)){
                        	$model->country_id = "No Country Selected";
                        } else {
                        	$model->country_id = Countries::model()->findByPk($model->country_id)->name;
                        }
                        $this->widget('zii.widgets.CDetailView', array(
                            // 'itemsCssClass' => 'table table-bordered table-hover dataTable',
                            'htmlOptions' => array("class" => "table table-bordered table-hover dataTable"),
                            'data' => $model,
                            'attributes' => array(
                                'username',
								'first_name',
								'last_name',
								'email',
								'phone',
								'state_id',
								'country_id',
						   ),
                        ));
                        ?>
                        <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/adminusers'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>