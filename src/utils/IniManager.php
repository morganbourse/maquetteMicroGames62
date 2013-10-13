<?php
/**
 * Read ini file easyly
 * @author Morgan
 *
 */
class IniManager {
    private static $instance;
    private $settings;
   
    /**
     * constructeur
     * @param unknown_type $ini_file
     */
    private function __construct($ini_file) {
        $this->settings = parse_ini_file($ini_file, true);
    }
   
    /**
     * get instance of this class
     * @param unknown_type $ini_file
     * @return Settings
     */
    public static function getInstance($ini_file) {
        if(! isset(self::$instance)) {
            self::$instance = new IniManager($ini_file);           
        }
        return self::$instance;
    }
   
    /**
     * get a property
     * @param unknown_type $setting
     * @return unknown
     */
    public function __get($setting) {
        if(array_key_exists($setting, $this->settings)) {
            return $this->settings[$setting];
        } else {
            foreach($this->settings as $section) {
                if(array_key_exists($setting, $section)) {
                    return $section[$setting];
                }
            }
        }
    }
}

?>