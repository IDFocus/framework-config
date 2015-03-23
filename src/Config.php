<?php
namespace InterExperts;

/**
 * Singleton geeft configuratieinstellingen voor deze installatie
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class Config {
	static private $instance = null;
	private $configValues = array();

	/**
	 * @codeCoverageIgnore
	 */
	private function __construct() {
		if(!$this->configFileExists()){
			throw new ConfigFileNotFoundException("Config file couldn't be found.");
		}
	}

	/**
	 *	Geeft een Config-object. Indien er nog geen object is geinitialiseerd wordt er een gecreëerd,
	 *	anders wordt het bestaande object geretourneerd.
	 * @codeCoverageIgnore
	*/
	static function getInstance() {
		if (!isset(Config::$instance)) {
			Config::$instance = new Config();
		}
		return Config::$instance;
	}

	/**
	 * Haalt een config waarde op. False als deze niet ingesteld is.
	 */
	public function get($section, $key){
		if(!isset($this->configValues[$section][$key])){
			return false;
		}
		return $this->configValues[$section][$key];
	}

	/**
	 * Gives all currently set config values
	 */
	public function getAll(){
		return $this->configValues;
	}

	/**
	 * Zet de waarden in de vorm van een array die, vervolgens 
	 * met deze class benadert kan worden.
	 */
	public function set($config){
		$this->configValues = $config;
	}

	protected function configFileExists($path = '/../../../../config/custom_config.inc.php'){
		return file_exists(dirname(__FILE__) . $path);
	}
}

class ConfigFileNotFoundException extends \Exception{}