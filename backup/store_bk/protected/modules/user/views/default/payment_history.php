<div class="inner_con bg_grey">
  <div class="wraper fc_black">
  	<h2 class="fw600 mart15 marb15 titel">Payment History</h2>
  		<div class="col-sm-12 table-responsive">
          <?php
          $this->widget('zii.widgets.grid.CGridView', array(
              'id' => 'genres-grid',
              'itemsCssClass' => 'p_histry table table-bordered table-striped',
              'dataProvider' => $model->search(),
              'enablePagination' => true,
              // 'filter'=>$model,
              'columns' => array(
                  'invoice',
                  array(
                      'name' => 'plan_id',
                      'value' => array($this, 'gridPlan')
                  ),
                  'transaction_id',
                  'amount',
                  'payment_method',
                  'payment_status',
                  /*
                  array(
                      'class'=>'CButtonColumn',
                      'template'=>'{v}', // <-- TEMPLATE WITH THE TWO STATES
                      'htmlOptions'=>array(
                              'width'=>80,
                      ),
                      'buttons' => array(
                          'v'=>array(
                                  'label'=>'<i class="fa fa-search"></i>',
                                  'url'=>'Yii::app()->createUrl("user/genres/view", array("id"=>$data->id))',
                                  'options'=>array('class'=>'view','title'=>'View'),
                          ),
                      ),
                  )*/
              ),
          ));
          ?>
      </div>
	</div>
</div>