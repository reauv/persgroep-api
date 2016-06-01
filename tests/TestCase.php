<?php

    class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->baseUrl = env('APP_URL', $this->baseUrl);

        return $app;
    }

    /**
     * Set API url as base url.
     *
     * @return this
     */
    public function api()
    {
        $this->baseUrl = $this->baseUrl . '/' . env('API_PREFIX');

        return $this;
    }
}
