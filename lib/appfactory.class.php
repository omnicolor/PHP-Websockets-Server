<?php
/**
 * Application factory.
 */

require_once "wsexceptions.class.php";


/**
 * Application factory.
 */
class AppFactory {
    /**
     * Create a new application instance.
     * @param string $appName Name of the application to create.
     * @param array $param Optional parameters to pass to new application.
     * @return StdClass Requested application.
     * @throws WSAppNotInstalled
     */
    public static function create($appName, $params = NULL) {
        if(class_exists($appName)) {
            if($params == NULL) {
                return new $appName();
            }
            $obj = new ReflectionClass($appName);
            return $obj->newInstanceArgs($params);
        }

        throw new WSAppNotInstalled("Class [ $appName ] not found...");
    }


    /**
     * This is the autoload, so no need to require all classes
     * And it throws exception if there's no such file
     * @author Roy
     * @param string $appName Name of the application to require.
     */
    public static function autoload($appName) {
        if (file_exists($file = "$appName.class.php")) {
            require_once $file;
            return;
        }
        if (file_exists($file2 = "./$appName/$file")) {
            require_once $file2;
            return;
        }
        throw new WSAppNotInstalled("File [ $appName.class.php ] not found...");
    }
}
