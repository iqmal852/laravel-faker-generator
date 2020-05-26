<?php

namespace Iqmal\LaravelFakerGenerator\Tests;

use Iqmal\LaravelFakerGenerator\LaravelFakerGenerator;
use Iqmal\LaravelFakerGenerator\LaravelFakerGeneratorFacade;
use Iqmal\LaravelFakerGenerator\LaravelFakerGeneratorServiceProvider;
use Orchestra\Testbench\TestCase;

class AccessibleRouteTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
          LaravelFakerGeneratorServiceProvider::class
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'LaravelFakerGenerator' => LaravelFakerGeneratorFacade::class
        ];
    }

    /** @test */
    public function index_route_can_be_accessed()
    {
        $this->get('/faker')
        ->assertStatus(200);
    }
}
