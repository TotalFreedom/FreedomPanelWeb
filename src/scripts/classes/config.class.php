<?php
class Config {

  private static $config_values;

  public static function get($name) {

    if (self::$config_values[$name]) {
      return self::$config_values[$name];
    } else {
      echo "ded";
      // Add error handling function here
    }

  }

  public static function new($name, $value) {
    if (self::$config_values[$name] = $value) {
      return true;
    } else {
      echo "ded";
    }
  }

}
?>
