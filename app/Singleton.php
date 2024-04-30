<?php
namespace App;

class Singleton
{
    private static array $instances = [];

    /**
     * @param mixed ...$args
     * @return static
     */
    public static function getInstance(...$args): static
    {
        $class = static::class;;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static(...$args);
        }

        return self::$instances[$class];
    }
}