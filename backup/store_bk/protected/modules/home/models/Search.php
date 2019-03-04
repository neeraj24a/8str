<?php

class Search extends CFormModel {

    public $srch_txt;

    public function rules() {
        return array(
            array('srch_txt', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'srch_txt' => 'Search...',
        );
    }
    
    public function getSongs()
    {
        
    } 
    
    public function getVideos()
    {
        
    }   
    
    public function getDj()
    {
        
    }        
    
    
    
    

}
