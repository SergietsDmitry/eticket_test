<?php

namespace App\Libs\Cities;

use Illuminate\Database\Eloquent\Model;
/**
 * CityList
 *
 */
class Cities extends Model {
	/**
	 * @var string
	 * Path to the directory containing cities data.
	 */
	protected $cities;
	/**
	 * @var string
	 * The table for the cities in the database, is "cities" by default.
	 */
	protected $table;
    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
       $this->table = \Config::get('cities.table_name');
    }
    /**
     * Get the cities from the JSON file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getCities()
    {
        //Get the cities from the JSON file
        if (sizeof($this->cities) == 0){
            $this->cities = json_decode(file_get_contents(__DIR__ . '/cities.json'), true);
        }
        //Return the cities
        return $this->cities;
    }
    
    public function getCityByCode($code)
    {
        $cities = $this->getCities();
        
        foreach($cities as $city)
        {

            if ((array_key_exists('iso_3166_3', $city) && strtolower($city['iso_3166_3']) == strtolower($code)) ||
                (array_key_exists('iso_3166_2', $city) && strtolower($city['iso_3166_2']) == strtolower($code)))
            {
                return $city;
            }
        }
        
        return false;
    }
    
    public function getCityByName($name)
    {
        $cities = $this->getCities();
        
        foreach($cities as $city)
        {

            if ((array_key_exists('full_name', $city) && strtolower($city['full_name']) == strtolower($name)) ||
                (array_key_exists('name', $city) && strtolower($city['name']) == strtolower($name)))
            {
                return $city;
            }
        }
        
        return false;
    }
    
	/**
	 * Returns one city
	 *
	 * @param string $id The city id
     *
	 * @return array
	 */
	public function getOne($id)
	{
        $cities = $this->getCities();
		return $cities[$id];
	}
	/**
	 * Returns a list of cities
	 *
	 * @param string sort
	 *
	 * @return array
	 */
	public function getList($sort = null)
	{
	    //Get the cities list
	    $cities = $this->getCities();
	    //Sorting
	    $validSorts = array(
					'iso_3166_3',
					'country_code',
					'name'
        );
	    if (!is_null($sort) && in_array($sort, $validSorts)){
	        uasort($cities, function($a, $b) use ($sort) {
	            if (!isset($a[$sort]) && !isset($b[$sort])){
	                return 0;
	            } elseif (!isset($a[$sort])){
	                return -1;
	            } elseif (!isset($b[$sort])){
	                return 1;
	            } else {
	                return strcasecmp($a[$sort], $b[$sort]);
	            }
	        });
	    }
	    //Return the cities
		return $cities;
	}
	/**
	 * Returns a list of cities suitable to use with a select element in Laravelcollective\html
	 *
	 * @param string sort
	 *
	 * @return array
	 */
	public function getListForSelect($sort = null)
	{
		foreach ($this->getList('name') as $key => $value) {
			$cities[$key] = $value['name'];
		}
		//return the array
		return $cities;
	}
}