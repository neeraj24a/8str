<section class="content-header">
    <h1>
        Pages Content
    </h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="<?php echo base_url() . '/admin/pages'; ?>"><i class="fa fa-dashboard"></i> Pages Content</a></li>
	    <li class="active">View</li>
   </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php 
							$names = getParam('page_name');
							$model->page_name = $names[$model->page_name];
							echo $model->page_name; 
						?> 
                        <small>
                            <a href="<?php echo base_url() . '/admin/pages/update?id=' . $model->id; ?>">EDIT</a>
                        </small>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
						$this->widget('zii.widgets.CDetailView', array(
                            'htmlOptions' => array("class" => "table table-bordered table-hover dataTable"),
                            'data' => $model,
                            'attributes' => array(
                                'page_name',
								'description:html'
                            ),
                        ));
                        ?>
                        <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/pages'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>