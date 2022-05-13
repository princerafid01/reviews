<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe3edcce70777d934a24093d8789a9c1
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe3edcce70777d934a24093d8789a9c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe3edcce70777d934a24093d8789a9c1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbe3edcce70777d934a24093d8789a9c1::$classMap;

        }, null, ClassLoader::class);
    }
}
