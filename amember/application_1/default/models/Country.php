<?php
/**
 * Class represents records from table countries
 * {autogenerated}
 * @property int $country_id
 * @property string $country
 * @property string $title
 * @property int $tag
 * @property string $status enum('added','changed')
 * @see Am_Table
 */

class Country extends Am_Record
{
    const STATUS_ADDED = 'added';
    const STATUS_CHANGED = 'changed';

    function insert($reload = true)
    {
        $this->status = self::STATUS_ADDED;
        parent::insert($reload);
    }

    function update()
    {
        $this->status = get_first($this->status, self::STATUS_CHANGED);
        parent::update();
    }
}

class CountryTable extends Am_Table
{
    protected $_key = 'country_id';
    protected $_table = '?_country';
    protected $_recordClass = 'Country';

    function sortByTagAndTitle($a, $b)
    {
        if($a['tag'] != $b['tag']) return ($a['tag'] > $b['tag'] ? -1 : 1);
        return strcmp($a['title'], $b['title']);
    }

    function getTitleByCode($code)
    {
        return $this->_db->selectCell("SELECT title
            FROM ?_country
            WHERE country=?", $code);
    }

    function getOptions($addEmpty = false)
    {
        //if admin show all countries, if user show only active countries
        $where = defined('AM_ADMIN') ? '' : 'WHERE tag>=0';
        $res = $this->_db->select("SELECT country as ARRAY_KEY,
                CASE WHEN tag<0 THEN CONCAT(title, ' (disabled)') ELSE title END AS title
                , tag
                FROM ?_country $where
                ORDER BY tag DESC, title");

        if (strpos($this->getDi()->app->getDefaultLocale(), 'en')!==0)
        {
            $tr = $this->getDi()->locale->getTerritoryNames();
            foreach ($res as $k => $v)
                if (array_key_exists($k, $tr)) $res[$k]['title'] = $tr[$k];
        }
        uasort($res, array($this, 'sortByTagAndTitle'));
        $res = array_map(function($l) {return $l["title"];}, $res);
        if ($res && $addEmpty) {
            $res = array_merge(array('' => ___('[Select country]')), $res);
        }
        return $res;
    }
}