<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite123104b82e8a6f6a71993db311b5474
{
    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'Everyman\\Neo4j' => 
            array (
                0 => __DIR__ . '/..' . '/everyman/neo4jphp/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInite123104b82e8a6f6a71993db311b5474::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
