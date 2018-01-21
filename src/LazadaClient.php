<?php
/**
 * Created by Ramadhan
 * Date: 20/01/2018
 * Time: 23:52
 */

namespace ramadhan;

use Exception;
use GuzzleHttp\Client;

class LazadaClient {
	
	private $config = [
		'UserID'  => null,
		'ApiKey'  => null,
		'ApiHost' => null,
		'Format'  => 'XML',
		'Action'  => null,
		'Version' => "1.0",
	];
	
	protected $client = null;
	
	public function __construct( array $config ) {
		
		foreach ( $config as $key => $value ) {
			if ( array_key_exists( $key, $this->config ) ) {
				$this->config[ $key ] = $value;
			}
		}
		
		$required_keys = [
			'UserID',
			'ApiKey',
			'ApiHost',
			'Format',
		];
		
		foreach ( $required_keys as $key ) {
			if ( is_null( $this->config[ $key ] ) ) {
				throw new Exception( 'Required field ' . $key . ' is not set' );
			}
		}
		
		// Pay no attention to this statement.
		// It's only needed if timezone in php.ini is not set correctly.
		date_default_timezone_set( "UTC" );
		
		// The current time. Needed to create the Timestamp parameter below.
		$now = new \DateTime();
		
		// The current time in ISO8601 format
		$this->config['Timestamp'] = $now->format( \DateTime::ISO8601 );
	}
	
	/**
	 * A method to computing the signature parameter
	 * @return boolean
	 */
	private function parameters( $query ) {
		
		// The parameters for the GET request. These will get signed.
		$parameters = array(
			// The ID of the user making the call.
			'UserID'    => $this->config['UserID'],
			
			// The API version. Currently must be 1.0
			'Version'   => $this->config['Version'],
			
			// The format of the result.
			'Format'    => $this->config['Format'],
			
			// The current time in ISO8601 format
			'Timestamp' => $this->config['Timestamp']
		);
		
		$parameters = array_merge( $parameters, $query );
		// Sort parameters by name.
		ksort( $parameters );
		
		// URL encode the parameters.
		$encoded = array();
		foreach ( $parameters as $name => $value ) {
			$encoded[] = rawurlencode( $name ) . '=' . rawurlencode( $value );
		}
		
		// Concatenate the sorted and URL encoded parameters into a string.
		$concatenated = implode( '&', $encoded );
		
		// The API key for the user as generated in the Seller Center GUI.
		// Must be an API key associated with the UserID parameter.
		$api_key = $this->config['ApiKey'];
		
		// Compute signature and add it to the parameters.
		$parameters['Signature'] = rawurlencode( hash_hmac( 'sha256', $concatenated, $api_key, false ) );
		
		return $parameters;
	}
	
	/**
	 * A method to Call A Request
	 *
	 * @param      $query
	 * @param      $method
	 * @param null $body
	 *
	 * @return array|mixed|string
	 */
	private function request( $query, $method, $body = null) {
		$parameters = $this->parameters( $query );
		
		// Build Query String
		$queryString = http_build_query( $parameters, '', '&', PHP_QUERY_RFC3986 );
		
		if ( $this->client === null ) {
			$this->client = new Client();
		}
		
		$requestOptions = [
			'allow_redirects' => true,
			'body'            => $body
		];
		
		$response = $this->client->request( $method, $this->config['ApiHost'] . "?" . $queryString, $requestOptions );
		
		if ( strpos( strtolower( $response->getHeader( 'Content-Type' )[0] ), 'xml' ) !== false ) {
			$body = (string) $response->getBody();
			
			return $this->xmlToArray( $body );
			
		} else {
			$body = json_decode( $response->getBody(), true );
			
			if ( isset( $body['SuccessResponse'] ) ) {
				return $body['SuccessResponse'];
			}
			
			return json_decode( $response->getBody(), true )['ErrorResponse'];
		}
	}
	
	/**
	 * Convert an xml string to an array
	 *
	 * @param string $xmlstring
	 *
	 * @return array
	 */
	private function xmlToArray( $xmlstring ) {
		return json_decode( json_encode( simplexml_load_string( $xmlstring ) ), true );
	}
	
	/**
	 * A method to Get A Brands
	 *
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function GetBrands( $limit = 100, $offset = 0 ) {
		$response = $this->request( array( 'Action' => 'GetBrands', 'Limit' => $limit, 'Offset' => $offset ), 'GET' );
		
		if ( isset( $response['Head']['ErrorMessage'] ) ) {
			throw new Exception( $response['Head']['ErrorMessage'] );
		}
		
		return $response['Body'];
	}
	
}