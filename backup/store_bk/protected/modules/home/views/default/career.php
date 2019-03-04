<?php
$baseUrl = Yii::app()->theme->baseUrl;
?> 
<div class="clearfix"></div>
<!-- // BANNER AREA START // -->
<div class="aboutus_area no-bg">
    <div class="container">
        <div class="row">
            <div class="about_inner">        
                <div class="col-md-12">
                    <h1 style="background:none;">CAREER</h1>          
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // BANNER AREA END // -->
<div class="clearfix"></div>
<!-- // CONT AREA START  // -->
<div class="clinic_area">
    <div class="clinic_inner animatedParent">
        <div class="container">
            <div class="row">
                <h1 style="padding:0;">&nbsp;</h1>
            </div>
            <div class="row career-top">
                <p>Interested in joining us? Then Fill below form along with your updated CV.</p>
                <p>For Any Query Contact our HR @ hr.naturaxion@gmail.com</p>
            </div>
            <div class="row" style="margin-top: 20px;border-bottom: 1px solid #fff;">
                <div class="col-md-12">
                    <?php if(Yii::app()->user->hasFlash('success')):?>
                        <div class="flash-success">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(Yii::app()->user->hasFlash('error')):?>
                        <div class="flash-success">
                            <?php echo Yii::app()->user->getFlash('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="career-form">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'careers-form',
                            // Please note: When you enable ajax validation, make sure the corresponding
                            // controller action is handling ajax validation correctly.
                            // There is a call to performAjaxValidation() commented in generated controller code.
                            // See class documentation of CActiveForm for details on this.
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                        ));
                        ?>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'first_name', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'first_name',array("class" => "form-group",'size'=>60,'maxlength'=>128)); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'first_name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'middle_name', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'middle_name',array("class" => "form-group",'size'=>60,'maxlength'=>128)); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'midddle_name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'last_name', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'last_name',array("class" => "form-group",'size'=>60,'maxlength'=>128)); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'last_name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'email', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'email',array("class" => "form-group",'size'=>60,'maxlength'=>256)); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'email'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'mobile', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'mobile',array("class" => "form-group",'size'=>60,'maxlength'=>10)); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'mobile'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <?php echo $form->labelEx($model,'cv', array("class" => "form-group")); ?>
                            </div>
                            <div class="col-md-1">
                                <span class="seperator">:</span>
                            </div>
                            <div class="col-md-5">
                                <?php echo $form->fileField($model,'cv',array("class" => "form-group")); ?>
                                <p style="color:#fff;">Please Choose Only PDF, DOC or DOCX File.</p>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->error($model,'cv'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save',array('class'=>"btn btn-success")); ?>
                            </div>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- // CONT AREA END  // -->
<div class="clearfix"></div>