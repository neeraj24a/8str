<?php

/**
 * This is the model class for table "downloads".
 *
 * The followings are the available columns in table 'downloads':
 * @property string $id
 * @property string $user_id
 * @property string $song_id
 * @property string $owner_id
 * @property integer $type
 * @property integer $status
 * @property integer $deleted
 * @property string $date_entered
 * @property string $date_modified
 * @property string $created_by
 * @property string $modified_by
 */
class Downloads extends BaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'downloads';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, user_id, song_id, owner_id, type, date_entered, date_modified, created_by, modified_by', 'required'),
            array('type, status, deleted', 'numerical', 'integerOnly' => true),
            array('id, user_id, song_id, owner_id, created_by, modified_by', 'length', 'max' => 36),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, song_id, owner_id, type, status, deleted, date_entered, date_modified, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'song_detail' => array(self::BELONGS_TO, 'Songs', 'song_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'song_id' => 'Song',
            'owner_id' => 'Owner',
            'type' => 'Type',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('song_id', $this->song_id, true);
        $criteria->compare('owner_id', $this->owner_id, true);
        $criteria->compare('type', $this->type);
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
     * @return Downloads the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
     public function trendingSong($owner_id) {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d",strtotime("-7 days"));
        
        $sql = "SELECT song_id,count(*) as download_count FROM `downloads` WHERE `owner_id` = '$owner_id' "
                . "and type = 1 and DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' "
                . "group by `song_id` order by download_count DESC limit 0,20";
        $result = BaseModel::executeSimpleQuery($sql);
        if (!empty($result)) {
            $id_array = array();
            foreach ($result as $val) {
                array_push($id_array, $val['song_id']);
            }

            $criteria = new CDbCriteria();
            $criteria->condition = "status = '1'  AND deleted = 0";
            $criteria->addInCondition('id', $id_array);
            $songs_list = Songs::model()->findAll($criteria);
            return $songs_list;
        }
    }
    
    
    public function HomeTrendingSong() {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d",strtotime("-7 days"));
        
        $sql = "SELECT song_id,count(*) as download_count FROM `downloads` WHERE "
                . " type = 1 and DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' "
                . "group by `song_id` order by download_count DESC limit 0,20";
        $result = BaseModel::executeSimpleQuery($sql);
        if (!empty($result)) {
            $id_array = array();
            foreach ($result as $val) {
                array_push($id_array, $val['song_id']);
            }

            $criteria = new CDbCriteria();
            $criteria->condition = "status = '1'  AND deleted = 0";
            $criteria->addInCondition('id', $id_array);
            $songs_list = Songs::model()->findAll($criteria);
            return $songs_list;
        }
    }
    
    public function trendingVideo($owner_id) {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d",strtotime("-7 days"));
        
        $sql = "SELECT song_id,count(*) as download_count FROM `downloads` WHERE `owner_id` = '$owner_id' "
                . "and type = 2 and DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' "
                . "group by `song_id` order by download_count DESC limit 0,20";
        $result = BaseModel::executeSimpleQuery($sql);
        $result = BaseModel::executeSimpleQuery($sql);
        if (!empty($result)) {
            $id_array = array();
            foreach ($result as $val) {
                array_push($id_array, $val['song_id']);
            }

            $criteria = new CDbCriteria();
            $criteria->condition = "status = '1'  AND deleted = 0";
            $criteria->addInCondition('id', $id_array);
            $songs_list = Songs::model()->findAll($criteria);
            return $songs_list;
        }
    }
    
    public function HomeTrendingVideo() {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d",strtotime("-7 days"));
        
        $sql = "SELECT song_id,count(*) as download_count FROM `downloads` WHERE "
                . "type = 2 and DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' "
                . "group by `song_id` order by download_count DESC limit 0,20";
        $result = BaseModel::executeSimpleQuery($sql);
        $result = BaseModel::executeSimpleQuery($sql);
        if (!empty($result)) {
            $id_array = array();
            foreach ($result as $val) {
                array_push($id_array, $val['song_id']);
            }

            $criteria = new CDbCriteria();
            $criteria->condition = "status = '1'  AND deleted = 0";
            $criteria->addInCondition('id', $id_array);
            $songs_list = Songs::model()->findAll($criteria);
            return $songs_list;
        }
    }

}
