

<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'song_edit_form',
    'action' => array("/user/EditSong?song=$song_model->id"),
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
        'validateOnSubmit' => true,
    )
        ));
?>
<div class="m_row">
    <div class="m_col">
        <?php echo $form->labelEx($song_model, 'song_name'); ?>
    </div>
    <div class="m_col">
        <?php echo $form->textField($song_model, 'song_name', array('placeholder' => 'Song Name', 'class' => 't_box')); ?>
        <?php echo $form->error($song_model, 'song_name'); ?>
    </div>
</div>

<div class="m_row">
    <div class="m_col">
        <?php echo $form->labelEx($song_model, 'artist_name'); ?>
    </div>
    <div class="m_col">
        <?php echo $form->textField($song_model, 'artist_name', array('placeholder' => 'Artist Name', 'class' => 't_box')); ?>
        <?php echo $form->error($song_model, 'artist_name'); ?>
    </div>
</div>

<div class="m_row">
    <div class="m_col">
        <?php echo $form->labelEx($song_model, 'genre'); ?>
    </div>
    <div class="m_col">
        <?php
            $genres = BaseModel::getAll("Genres");
            $genres = CHtml::listData($genres, 'id', 'name');
        ?>
        <?php echo $form->dropDownList($song_model, 'genre', $genres, array('empty' => 'Select Genre', 'class' => 't_box')); ?>
        <?php echo $form->error($song_model, 'genre'); ?>
    </div>
</div>


<div class="m_row">
    <div class="m_col">
        <?php echo $form->labelEx($song_model, 'bpm'); ?>
    </div>
    <div class="m_col">
        <?php echo $form->textField($song_model, 'bpm', array('placeholder' => 'BPM', 'class' => 't_box')); ?>
        <?php echo $form->error($song_model, 'bpm'); ?>
    </div>
</div>

<div class="m_row">
    <div class="m_col">
        <?php echo $form->labelEx($song_model, 'song_key'); ?>
    </div>
    <div class="m_col">
        <?php echo $form->textField($song_model, 'song_key', array('placeholder' => 'Song Key', 'class' => 't_box')); ?>
        <?php echo $form->error($song_model, 'song_key'); ?>
    </div>
</div>


<div class="m_row tar">
    <?php echo CHtml::submitButton('Update', array('class' => 'btn_small fc_white bg_blue')); ?>
</div>
<?php $this->endWidget(); ?>