<?php

/**
 * Created by PhpStorm.
 * User: simchay
 * Date: 1/25/2016
 * Time: 4:50 PM
 */
class Ip
{

    private $ip_raw;

    public function __construct($ip=null){
		if(!$ip){
			$ip = $this->findIp();
		}
        $this->ip_raw = $ip;
    }

    public function findIp(){
		$ip_keys = array(
			'HTTP_INCAP_CLIENT_IP',
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR'
		);

		foreach($ip_keys as $key){
			if(array_key_exists($key, $_SERVER) && !empty($_SERVER[$key])){
				$tmp_ip = $_SERVER[$key];
				break;
			}
		}
		return $tmp_ip;
    }

	public function ip(){
		return $this->get_real_ip();
	}

	public function __toString(){
		return $this->get_real_ip();
	}

	private function get_real_ip(){
		$ips = explode(',', str_replace(' ', '', $this->ip_raw));
			// find first ip which is not a private network address
			foreach($ips as $ip){
				$octets = explode('.', $ip);
				if(
                    // https://en.wikipedia.org/wiki/Private_network
					$octets[0] == '10' // 10.x.x.x
					|| ($octets[0] == '192' && $octets[1] == '168') // 192.168.x.x
					|| ($octets[0] == '172' && intval($octets[1] > 15)) ){
						continue;
					}
				break; // not a private address, use as real ip
			}
		return $ip;
	}






}
