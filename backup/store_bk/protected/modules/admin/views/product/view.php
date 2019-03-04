<section class="content-header">
    <h1>
        Products
    </h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="<?php echo base_url() . '/admin/product'; ?>"><i class="fa fa-dashboard"></i> Products</a></li>
	    <li class="active">View</li>
   </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $model->name; ?> 
                        <small>
                            <a href="<?php echo base_url() . '/admin/product/update?id=' . $model->id; ?>">EDIT</a>
                        </small>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            // 'itemsCssClass' => 'table table-bordered table-hover dataTable',
                            'htmlOptions' => array("class" => "table table-bordered table-hover dataTable"),
                            'data' => $model,
                            'attributes' => array(
                                'sku',
								'name',
								'category',
								'slug',
								'quantity',
								'short_desc',
								'description',
								'in_stock'
							),
                        ));
                        ?>
                        <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/product'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
		
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        Product Gallery
                    </h3>
                    <div class="row">
                        <div class="col-xs-4" style="float:right;">
                            <a href="<?php echo base_url().'/admin/productGallery/create?product='.$model->id; ?>" class="btn btn-info" style="float:right;">Add Product Images</a>
                        </div>    
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'product-gallery-grid',
                                    'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                    'dataProvider' => $gallery->search($model->id),
                                    'enablePagination' => true,
                                    'columns' => array(
                                        array(
                                              'name' => 'image',
											  'type' => 'raw',
                                              'value' => array($this, 'gridImage'),
                                          ),
										array(
                                              'name' => 'image_type',
											  'type' => 'raw',
                                              'value' => array($this, 'gridImageType'),
                                          ),
                                        array
                                            (
                                            'class' => 'CButtonColumn',
                                            'template' => '{edit}',
                                            'buttons' => array
                                                (
                                                'edit' => array
                                                    (
                                                    'label' => 'EDIT',
                                                    'url' => 'Yii::app()->createUrl("admin/productGallery/update", array("id"=>$data->id))',
                                                ),
                                            ),
                                        ),
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div>
                    </div>
                </div>
            </div>
		</div>
		
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        Related Products
                    </h3>
                    <div class="row">
                        <div class="col-xs-4" style="float:right;">
                            <a href="<?php echo base_url().'/admin/relatedProducts/create?product='.$model->id; ?>" class="btn btn-info" style="float:right;">Add Related Product</a>
                        </div>    
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'related-products-grid',
                                    'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                    'dataProvider' => $related->search($model->id),
                                    'enablePagination' => true,
                                    'columns' => array(
                                        array(
                                              'name' => 'related',
                                              'value' => array($this, 'gridRelated'),
                                          ),
                                        array
                                            (
                                            'class' => 'CButtonColumn',
                                            'template' => '{edit}',
                                            'buttons' => array
                                                (
                                                'edit' => array
                                                    (
                                                    'label' => 'EDIT',
                                                    'url' => 'Yii::app()->createUrl("admin/relatedProducts/update", array("product"=>$data->product))',
                                                ),
                                            ),
                                        ),
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</section>
