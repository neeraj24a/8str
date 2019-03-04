<?php

/**
 * This is the model class for table "media".
 *
 * The followings are the available columns in table 'media':
 * @property string $id
 * @property string $song_name
 * @property string $artist_name
 * @property string $slug
 * @property string $s3_bucket
 * @property string $file_name
 * @property integer $type
 * @property string $bpm
 * @property string $song_key
 * @property string $file_size
 * @property string $genre
 * @property string $sub_genre
 * @property string $sub_sub_genre
 * @property string $s3_url
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class WidgetSongs extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'media';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, song_name, artist_name, slug, s3_bucket, file_name, type, genre, created_by, modified_by, date_entered, date_modified', 'required'),
            array('type, status, deleted', 'numerical', 'integerOnly' => true),
            array('id, genre, sub_genre, sub_sub_genre, created_by, modified_by', 'length', 'max' => 36),
            array('song_name, artist_name, s3_bucket', 'length', 'max' => 128),
            array('slug, file_name', 'length', 'max' => 256),
            array('bpm', 'length', 'max' => 16),
            array('song_key', 'length', 'max' => 32),
            array('s3_url', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, song_name, artist_name, slug, s3_bucket, file_name, type, bpm, song_key, genre, sub_genre, sub_sub_genre, s3_url, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'media_genre' => array(self::BELONGS_TO, 'Genres', 'genre'),
            'media_sub_genre' => array(self::BELONGS_TO, 'Genres', 'sub_genre'),
            'media_sub_sub_genre' => array(self::BELONGS_TO, 'Genres', 'sub_sub_genre'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'song_name' => 'Song Name',
            'artist_name' => 'Artist Name',
            'slug' => 'Slug',
            's3_bucket' => 'S3 Bucket',
            'file_name' => 'File Name',
            'type' => 'Type',
            'bpm' => 'Bpm',
            'song_key' => 'Song Key',
            'genre' => 'Genre',
            'sub_genre' => 'Sub Genre',
            'sub_sub_genre' => 'Sub Sub Genre',
            's3_url' => 'S3 Url',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
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
        $criteria->compare('song_name', $this->song_name, true);
        $criteria->compare('artist_name', $this->artist_name, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('s3_bucket', $this->s3_bucket, true);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('type', 1);
        $criteria->compare('bpm', $this->bpm, true);
        $criteria->compare('song_key', $this->song_key, true);
        $criteria->compare('genre', $this->genre, true);
        $criteria->compare('sub_genre', $this->sub_genre, true);
        $criteria->compare('sub_sub_genre', $this->sub_sub_genre, true);
        $criteria->compare('s3_url', $this->s3_url, true);
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
     * @return Songs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
