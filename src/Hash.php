<?php

namespace Razorpay\BloomFilter;

/**
* HashClass
* Use cases:
* -creates random hash generator
*/
class Hash {
	/**
	* Seed for unification every HashObject
	* @var array
	*/
	public $seed;
	
	/**
	* Parameters
	* @var array
	*/
	public $params;
	
	/**
	* Map of user setup parameters
	* @access private
	* @var boolean
	*/
	private $map = array(
		'strtolower' => array(
			'type' => 'boolean'
		)
	);
	
	/**
	* Initialization
	*
	* @param array parameters
	* @return object HashObject
	*/
	public function __construct($setup = null, $hashes = null) {
		/**
		*	Default parameters
		*/
		$params = array(
			'strtolower' => true
		);
		
		/**
		*	Applying income user parameters 
		*/
		$params = Map::apply($this->map, $params, $setup);
		$this->params = $params;
		
		/**
		*	Creating unique seed
		*/
		$seeds = array();
		if($hashes)
			foreach($hashes as $hash)
				$seeds = array_merge( (array) $seeds, (array) $hash->seed );
		do {
			$hash = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		} while( in_array($hash, $seeds) );
		$this->seed[] = $hash;
	}
	
	/**
	* Hash use's crc32 and md5 algorithms to get number less than $size parameter
	*
	* @param mixed object to hash
	* @param int max number to return
	* @return int
	*/
	public function crc($string, $size) {
		$string = strval($string);
		
		if($this->params['strtolower'] === true)
			$string = mb_strtolower($string, 'UTF-8');
		
		return abs( crc32( md5($this->seed[0] . $string) ) ) % $size;
	}
}