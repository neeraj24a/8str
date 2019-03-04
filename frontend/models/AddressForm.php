<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BillingAddress
 *
 * @author SONY
 */
class AddressForm extends Model{
    
    public $first_name;
    public $last_name;
    public $address_line_1;
    public $address_line_2;
    public $landmark;
    public $city;
    public $state;
    public $country;
    public $zip;
    public $contact;
    public $is_default;
    public $ship_first_name;
    public $ship_last_name;
    public $ship_address_line_1;
    public $ship_address_line_2;
    public $ship_landmark;
    public $ship_city;
    public $ship_state;
    public $ship_country;
    public $ship_zip;
    public $ship_contact;
    public $ship_is_default;
    public $is_guest;
    public $guest_email;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        if (Yii::$app->user->isGuest){
            return [
                // name, email, subject and body are required
                [['first_name', 'guest_email', 'last_name', 'address_line_1', 'landmark', 'city', 'state', 'country', 'zip', 'contact','ship_first_name', 'ship_last_name', 'ship_address_line_1', 'ship_landmark', 'ship_city', 'ship_contact', 'ship_state', 'ship_country', 'ship_zip'], 'required'],
                // email has to be a valid email address
                [['guest_email'], 'email'],
				// [['contact, ship_contact', 'pattern' => '/^[0-9]$/']],
                [['zip','ship_zip'], 'integer'],
            ];
        } else {
            return [
            // name, email, subject and body are required
                [['first_name', 'last_name', 'address_line_1', 'landmark', 'city', 'state', 'country', 'zip', 'contact','ship_first_name', 'ship_last_name', 'ship_address_line_1', 'ship_landmark', 'ship_city', 'ship_contact', 'ship_state', 'ship_country', 'ship_zip'], 'required'],
                // [['contact, ship_contact', 'pattern' => '/^[0-9]$/']],
                [['zip','ship_zip'], 'integer'],
            ];
        }
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zip' => 'Zip',
            'contact' => 'Phone Number',
            'ship_first_name' => 'First Name',
            'ship_last_name' => 'Last Name',
            'ship_address_line_1' => 'Address Line 1',
            'ship_address_line_2' => 'Address Line 2',
            'ship_city' => 'City',
            'ship_state' => 'State',
            'ship_country' => 'Country',
            'ship_zip' => 'Zip',
            'ship_contact' => 'Phone Number',
            'is_guest' => 'Guest',
            'guest_email' => 'Guest Email'
        ];
    }
    
    
}
