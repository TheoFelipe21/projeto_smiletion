<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit031add6353f7bd7c7af4aa37e72833ec
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RedeSocial\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RedeSocial\\' => 
        array (
            0 => __DIR__ . '/../..' . '/RedeSocial',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit031add6353f7bd7c7af4aa37e72833ec::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit031add6353f7bd7c7af4aa37e72833ec::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit031add6353f7bd7c7af4aa37e72833ec::$classMap;

        }, null, ClassLoader::class);
    }
}