<?php

class App {
    protected static array $dependencies = [];

    public static function set ($alias, $dependency) {
        self::$dependencies[$alias] = $dependency;
    }

    public static function get (String $label) {
        if (array_key_exists(
            $key=$label,
            $search=self::$dependencies)) {
                return self::$dependencies[$label];
        }
        else {
            throw new Exception($message="No such dependency key/label found.");
        }
    }
}

?>