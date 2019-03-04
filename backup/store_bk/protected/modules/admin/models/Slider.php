<?php

/**
 * This is the model class for table "slider".
 *
 * The followings are the available columns in table 'slider':
 * @property string $id
 * @property string $type
 * @property string $label
 * @property string $color_code
 * @property string $image
 * @property string $background_image
 * @property string $video
 * @property string $title
 * @property string $sub_title
 * @property string $link1
 * @property string $link1_text
 * @property string $link2
 * @property string $link2_text
 * @property string $alignment
 * @property integer $status
 * @property integer $deleted
 * @property string $date_entered
 * @property string $date_modified
 * @property string $created_by
 * @property string $modified_by
 */
class Slider extends AdminBaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'slider';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, type, label, date_entered, created_by', 'required'),
            array('title', 'required', 'on' => 'normal_with_color_code_scenario'),
            array('title', 'required', 'on' => 'normal_with_background_image_scenario'),
            array('image', 'required', 'on' => 'image_scenario'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'safe' => false, 'on' => 'image_scenario', 'message' => 'wrong type'),
            array('image', 'required', 'on' => 'image_scenario_update'),
            array('image', 'file','allowEmpty'=>true,  'types' => 'jpg, gif, png', 'safe' => false, 'on' => 'image_scenario_update', 'message' => 'wrong type'),
            array('background_image', 'required', 'on' => 'normal_with_background_image_scenario'),
            array('background_image', 'file', 'types' => 'jpg, gif, png', 'safe' => false, 'on' => 'normal_with_background_image_scenario', 'message' => 'wrong type'),
            array('background_image', 'required', 'on' => 'normal_with_background_image_scenario_update'),
            array('background_image', 'file','allowEmpty'=>true, 'types' => 'jpg, gif, png', 'safe' => false, 'on' => 'normal_with_background_image_scenario_update', 'message' => 'wrong type'),
            array('alignment', 'required', 'on' => 'image_scenario'),
            array('video', 'required', 'on' => 'video_scenario'),
            array('video', 'file', 'types' => 'mp4,wmv', 'on' => 'video_scenario'),
            array('video', 'required', 'on' => 'video_scenario_update'),
            array('video', 'file','allowEmpty'=>true,'safe' => false, 'types' => 'mp4,wmv', 'on' => 'video_scenario_update'),
            array('status, deleted', 'numerical', 'integerOnly' => true),
            array('id, created_by, modified_by', 'length', 'max' => 36),
            array('type', 'length', 'max' => 36),
            array('label, color_code', 'length', 'max' => 100),
            array('title', 'length', 'max' => 256),
            array('alignment', 'length', 'max' => 1),
            array('image,background_image,video, sub_title, link1, link1_text, link2, link2_text, date_modified', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, label, color_code, image,background_image,video, title, sub_title, link1, link1_text, link2, link2_text, alignment, status, deleted, date_entered, date_modified, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'label' => 'Label',
            'color_code' => 'Color Code',
            'image' => 'Image',
            'background_image' => 'Background Image',
            'video' => 'Video',
            'title' => 'Title',
            'sub_title' => 'Sub Title',
            'link1' => 'Link1',
            'link1_text' => 'Link1 Text',
            'link2' => 'Link2',
            'link2_text' => 'Link2 Text',
            'alignment' => 'Title Alignment',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('color_code', $this->color_code, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('background_image', $this->background_image, true);
        $criteria->compare('video', $this->video, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('sub_title', $this->sub_title, true);
        $criteria->compare('link1', $this->link1, true);
        $criteria->compare('link1_text', $this->link1_text, true);
        $criteria->compare('link2', $this->link2, true);
        $criteria->compare('link2_text', $this->link2_text, true);
        $criteria->compare('alignment', $this->alignment, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('date_entered', $this->date_entered, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_by', $this->modified_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Slider the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getImage($file_name) {
        if(!empty($file_name))
        {    
            return "<img height='100' width='100' src='".base_url()."/assets/slider/image/$file_name'>";
        }
        else
        {
            return null;
        }    
    }
    
    public function getBgImage($file_name) {
        if(!empty($file_name))
        {    
            return "<img height='100' width='100' src='".base_url()."/assets/slider/background_image/$file_name'>";
        }
        else
        {
            return null;
        }    
    }

}
