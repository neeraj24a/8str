<section class="content-header">
    <h1>
        Update
        <small>Page Content</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url() . '/admin/pages'; ?>"><i class="fa fa-dashboard"></i> Pages</a></li>
        <li class="active">Add</li>
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
						echo $names[$model->page_name]; 
					?> Content</h3>
                </div>
                <?php $this->renderPartial('_form', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</section>