<?php 

class Debug
{
    protected static $_instances = array();

    public function __construct()
    {
        self::$_instances[] = $this;
    }

    public function __destruct()
    {
        unset(self::$_instances[array_search($this, self::$_instances, true)]);
    }

    /**
     * @param $includeSubclasses Optionally include subclasses in returned set
     * @returns array array of objects
     */
    public static function getInstances($includeSubclasses = false)
    {
        $return = array();
        foreach(self::$_instances as $instance) {
            if ($instance instanceof get_class($this)) {
                if ($includeSubclasses || (get_class($instance) === get_class($this)) {
                    $return[] = $instance;
                }
            }
        }
        return $return;
    }
}