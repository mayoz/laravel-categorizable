<?php

namespace Mayoz\Tests\Categorizable;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Mayoz\Categorizable\CategorizableServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->setupConfig($this->app);
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            CategorizableServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test');

        $app['config']->set('database.connections.test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Setup the application database.
     *
     * @param  \Illuminate\Foundation\Application   $app
     * @return void
     */
    protected function setUpDatabase($app)
    {
        $this->artisan('migrate', ['--database' => 'test']);

        $this->withFactories(__DIR__.'/factories');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Setup the application config.
     *
     * @param  \Illuminate\Foundation\Application   $app
     * @return void
     */
    protected function setupConfig($app)
    {
        $app['config']->set('categorizable.category', Category::class);
    }
}
