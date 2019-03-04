<div class="inner_con bg_grey">
	<div class="wraper fc_black">
	<h2 class="fw600 mart15 marb15 titel">Edit Your Profile</h2>
    	<div class="row">
          <div class="col-md-3 tac">
            	<div class="marb15"><img class="pro_img" src="<?php echo base_url(); ?>/assets/user-profile/<?php echo $model->profile_pic; ?>"></div>
                <h5 class="fw400 marb15">Account status:  <br>Active<br>(some information needed)</h5>
                <div><a class="btn_big bg_black" href="#">Edit Profile</a></div>
            </div>
            <div class="col-md-9">
            <?php
              $form = $this->beginWidget('CActiveForm', array(
                      'id'=>'users-form',
                      'enableClientValidation'=>true,
                      'enableAjaxValidation'=> true,
                      'clientOptions'=>array(
                          'validateOnChange'=>true,
                          'validateOnSubmit'=>true,
                      )
                  ));
            ?>
            <table cellspacing="0" cellpadding="0" border="1" width="100%" class="table">
              <tbody>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'username'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'username',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'first_name'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'first_name',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'last_name'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'last_name',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'email'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'email',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'phone'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'phone',array('size'=>'60','maxlength'=>'12','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'state_id'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'state_id',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="28%"><?php echo $form->labelEx($model,'country_id'); ?>:</td>
                  <td width="72%">
                    <?php echo $form->textField($model,'country_id',array('size'=>'60','maxlength'=>'128','class' => 't_box')); ?>
                  </td>  
                </tr>
                <tr>
                  <td width="100%" colspan="2">
                    <?php echo CHtml::submitButton('Save',array('class'=>'btn_small fc_white bg_blue')); ?>
                  </td>
                </tr>
              </tbody>
            </table>
            <?php $this->endWidget(); ?>
          </div> 
        </div>      
    </div>
</div>