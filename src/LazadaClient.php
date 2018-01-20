<?php
/**
 * Created by Ramadhan
 * Date: 20/01/2018
 * Time: 23:52
 */

namespace ramadhan;

use Exception;

class LazadaClient {
	
	const DATE_FORMAT = "Y-m-d\TH:i:s+\\0\\0\\:\\0\\0";
	
	private $config = [
		'userId'  => null,
		'apiKey'  => null,
		'apiHost' => null,
		'version' => 1.0,
	];
	
	public function __construct( array $config ) {
		
		foreach ( $config as $key => $value ) {
			if ( array_key_exists( $key, $this->config ) ) {
				$this->config[ $key ] = $value;
			}
		}
		
		$required_keys = [
			'userId',
			'apiKey',
			'apiHost'
		];
		
		foreach ( $required_keys as $key ) {
			if ( is_null( $this->config[ $key ] ) ) {
				throw new Exception( 'Required field ' . $key . ' is not set' );
			}
		}
	}
}