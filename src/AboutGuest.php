<?php

namespace Lexinzector\AboutGuest;

class AboutGuest
{
	public $is_browser = false;
	public $is_mobile = false;
	public $is_robot = false;
	
	public $browsers = array();
	public $operating_systems = array();
	public $mobiles = array();
	public $robots = array();
	
	public $ip = '';
	public $version = '';
	public $browser = '';
	public $browser_full_name = '';
	public $operating_system = '';
	public $os_version = '';
	public $robot = '';
	public $mobile = '';
	
	public function __construct($agent = '')
	{
		// Загружаем массивы для работы с данными
		$files = array('browsers', 'operating_systems', 'mobiles', 'robots');
		foreach($files as $file)
		{
			$this->load($file);
		}
		
		// Данные пользователя
		$this->agent = $agent;
		if($agent == '')
		{
			$this->agent = (@$_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		}
		// Вызываем методы для заполнения данных пользователя
		$setMethods = array('set_ip', 'set_browser', 'set_operating_system', 'set_robot', 'set_mobile');
		foreach($setMethods as $method)
		{
			$this->$method();
		}
	}
	
	private function load($file_and_array_name)
	{
		// Загружает массивы из папки с массивами
		$Load = realpath($raw = __DIR__.'/arrays/'.$file_and_array_name.'.php') ?: $raw;
		$this->$file_and_array_name = (!count($Load)) ? array() : $Load;
	}
	
	private function set_ip()
	{
		$this->ip = $_SERVER['REMOTE_ADDR'];
		return true;
	}
	
	private function set_browser()
	{
		if(is_array($this->browsers) and count($this->browsers) > 0)
		{
			foreach($this->browsers as $key => $val)
			{
				if(preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $this->agent, $match))
				{
					$this->is_browser = true;
					$this->version = $match[1];
					$this->browser = $val;
					$this->browser_full_name = $match[0];
					return true;
				}
			}
		}
		return false;
	}
	
	private function set_operating_system()
	{
		if(is_array($this->operating_systems) and count($this->operating_systems) > 0)
		{
			foreach($this->operating_systems as $key => $val)
			{
				if(preg_match("|".preg_quote($key).".*?([a-zA-Z]?[0-9\.]+)|i", $this->agent, $match))
				{
					$this->operating_system = $val;
					$this->os_version = $match[1];
					return true;
				}
			}
		}
		$this->operating_system = 'Unknown';
	}
	
	private function set_robot()
	{
		if(is_array($this->robots) and count($this->robots) > 0)
		{
			foreach($this->robots as $key => $val)
			{
				if(preg_match("|".preg_quote($key)."|i", $this->agent))
				{
					$this->is_robot = true;
					$this->robot = $val;
					return true;
				}
			}
		}
		return false;
	}
	
	private function set_mobile()
	{
		if(is_array($this->mobiles) and count($this->mobiles) > 0)
		{
			foreach($this->mobiles as $key => $val)
			{
				if(false !== (strpos(strtolower($this->agent), $key)))
				{
					$this->is_mobile = true;
					$this->mobile = $val;
					return true;
				}
			}
		}
		return false;
	}
}
