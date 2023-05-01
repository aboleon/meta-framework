<?php

namespace Tests\Unit\Mediaclass;

use MetaFramework\ServiceProvider;
use Orchestra\Testbench\TestCase;
use MetaFramework\Mediaclass\Config;
use Illuminate\Contracts\Filesystem\Filesystem;

class ConfigTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        // Register your package service provider
        return [
            // Your package service provider class
            ServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup the necessary configuration for your package
        $app['config']->set('filesystems.disks.public', ['driver' => 'local', 'root' => 'path/to/storage']);
        $app['config']->set('mediaclass.disk', 'media');
        $app['config']->set('mediaclass.dimensions', [
            'test_size' => [
                'width' => 123,
                'height' => 456,
            ],
        ]);
    }

    public function testGetSizes()
    {
        $sizes = Config::getSizes();

        $this->assertIsArray($sizes);
        $this->assertArrayHasKey('test_size', $sizes);
        $this->assertEquals(['width' => 123, 'height' => 456], $sizes['test_size']);
    }

    public function testGetDisk()
    {
        $disk = Config::getDisk();

        $this->assertInstanceOf(Filesystem::class, $disk);
    }
}
