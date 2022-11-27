<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit031add6353f7bd7c7af4aa37e72833ec
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit031add6353f7bd7c7af4aa37e72833ec', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit031add6353f7bd7c7af4aa37e72833ec', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit031add6353f7bd7c7af4aa37e72833ec::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
