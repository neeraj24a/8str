<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $profile_pic
 * @property integer $state_id
 * @property integer $country_id
 * @property integer $is_admin
 * @property string $role_id
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $updated_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Users extends BaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, username, password, email, created_by, date_entered', 'required'),
            array('state_id, country_id, is_admin, status, deleted', 'numerical', 'integerOnly' => true),
            array('id, role_id, created_by, modified_by', 'length', 'max' => 36),
            array('username, s3_bucket, first_name, last_name', 'length', 'max' => 128),
            array('password, email', 'length', 'max' => 255),
            // array('username','length', 'min' => 6),
            array('username, password', 'length', 'min' => 6),
            array('phone', 'length', 'max' => 16),
            array('profile_pic', 'length', 'max' => 256),
            array('date_modified', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, s3_bucket, first_name, last_name, email, phone, profile_pic, state_id, country_id, is_admin, role_id, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'followers_list' => array(self::HAS_MANY, 'Followers', 'user_id', 'condition' => 'followers_list.deleted = 0'),
            'country_name' => array(self::BELONGS_TO, 'Countries', 'country_id'),
            'state_name' => array(self::BELONGS_TO, 'States', 'state_id'),
            'songs_list' => array(self::HAS_MANY, 'Songs', 'created_by', 'condition' => 'songs_list.type = 1'),
            'videos_list' => array(self::HAS_MANY, 'Songs', 'created_by', 'condition' => 'videos_list.type = 2'),
            'following_list' => array(self::HAS_MANY, 'Followers', 'follower_id', 'condition' => 'following_list.deleted = 0'), // the users who is being followed by this user
            'playlist' => array(self::HAS_MANY, 'Playlists', 'user_id', 'condition' => 'playlist.deleted = 0'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            's3_bucket' => 'S3 Bucket',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'profile_pic' => 'Profile Pic',
            'state_id' => 'State',
            'country_id' => 'Country',
            'is_admin' => 'Is Admin',
            'role_id' => 'Role',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Updated By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('profile_pic', $this->profile_pic, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('is_admin', $this->is_admin);
        $criteria->compare('role_id', $this->role_id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_by', $this->modified_by, true);
        $criteria->compare('date_entered', $this->date_entered, true);
        $criteria->compare('date_modified', $this->date_modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function AjaxJustAdded($user, $song_type) {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d", strtotime("-7 days"));
        $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$user' AND DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' "));
        if (!empty($shared_songs)) {
            $shared_songs_ids = array();
            foreach ($shared_songs as $s) {
                array_push($shared_songs_ids, "'$s->song_id'");
            }
            $ids = implode(',', $shared_songs_ids);

            $criteria = new CDbCriteria();
            $criteria->condition = "status = '1'  AND deleted = 0 AND "
                    . "type = '$song_type' AND ((created_by = '$user' AND DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date' ) OR (id IN($ids)) ) ";
                   // . "AND DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date'";
            $criteria->order = "date_entered DESC";
            $criteria->limit = 20;

           
        } else {
             $criteria = new CDbCriteria();
            $criteria->condition = "status = '1' AND acl=0  AND deleted = 0 AND "
                    . "type = '$song_type' AND created_by = '$user' "
                    . "AND DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date'";
            $criteria->order = "date_entered DESC";
            $criteria->limit = 20;
        }

        $songs = Songs::model()->findAll($criteria);
        return $songs;
    }

    public function HomeAjaxJustAdded($song_type) {
        $current_date = date("Y-m-d");
        $previous_seven_days_date = date("Y-m-d", strtotime("-7 days"));
        $criteria = new CDbCriteria();
        $criteria->condition = "status = '1' AND acl=0  AND deleted = 0 AND "
                . "type = '$song_type' "
                . "AND DATE(date_entered) >= '$previous_seven_days_date' AND DATE(date_entered)<='$current_date'";
        $criteria->order = "date_entered DESC";
        $criteria->limit = 20;
        $songs = Songs::model()->findAll($criteria);
        return $songs;
    }

    public function HomeGenre($song_type, $genre) {
        $criteria = new CDbCriteria();
        $criteria->condition = "status = '1'  AND deleted = 0 AND "
                . "type = '$song_type' AND genre ='$genre' ";
        $criteria->order = "date_entered DESC";
        $criteria->limit = 20;
        $songs = Songs::model()->findAll($criteria);
        return $songs;
    }

    public function getRecommendList($user_id, $type) {
        $user_detail = Users::model()->findByPk($user_id);
        $user_following_list = $user_detail->following_list; // list of users being followed by this logged in user
        $user_following_list_arr = array();
        foreach ($user_following_list as $list) {
            array_push($user_following_list_arr, $list->user_id);
        }
        $recommend_list_locationwise = Users::model()->findAll(array(
            "condition" => "status = '1' AND deleted = '0' AND is_admin = '0' AND state_id = '$user_detail->state_id' AND  country_id = '$user_detail->country_id' AND id !='$user_id' "
        ));

        $recommend_list_locwise_arr = array();
        foreach ($recommend_list_locationwise as $list_locwise) {
            array_push($recommend_list_locwise_arr, $list_locwise->id);
        }

        $parent_following_list = array();
        foreach ($user_following_list as $user) {

            $user_model = Users::model()->findByPk($user->user_id);
            foreach ($user_model->following_list as $u) {
                if ($u->user_id != $user_id) {
                    array_push($parent_following_list, $u->user_id);
                }
            }
        }

        $merged_array = array_merge($parent_following_list, $recommend_list_locwise_arr);
        $unique_merged_array = array_unique($merged_array);

        $final_recommended_arr = array_diff($unique_merged_array, $user_following_list_arr);

        // getting the final recommended user lists

        $criteria = new CDbCriteria();
        $criteria->condition = "status = '1'  AND deleted = 0";
        if ($type == "limited") {
            $criteria->limit = 5;
        }
        $criteria->addInCondition('id', $final_recommended_arr);
        $final_recommended_user_lists = Users::model()->findAll($criteria);





        return $final_recommended_user_lists;
    }

}
