<?php
class ImopediaSoap
{

	function __construct($url,$user, $password)
	{
		//print_r($url);
		ini_set('soap.wsdl_cache_enabled', '0');
		ini_set('soap.wsdl_cache_ttl', '0');

		$this->user = $user;
		$this->password = $password;

		$this->client = new SoapClient($url, array('cache_wsdl' => 0,'trace' => 1) );
	}

	function connect()
	{

		$this->sess_id = $this->client->__soapCall('login', array('username' => $this->user, 'password' => $this->password));
		return $this->sess_id;

	}

	function disconnect()
	{
		$result = $this->client->__soapCall('logout', array('session_id'=> $this->sess_id));
	}

	function execute($method, $options)
	{
		$foo = array();
		$foo['session_id'] = $this->sess_id;
		$foo['options'] = $options;
		return $result = $this->client->__soapCall($method, $foo);
	}


}
?>