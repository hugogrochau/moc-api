<?php
namespace MocApi\Tests;

use GuzzleHttp\Client;

/**
 *
 */
define('PROJECT_ROOT', realpath(__DIR__ . '/../../..'));
require_once PROJECT_ROOT . '/vendor/autoload.php';

/**
 * Class WebApiTestCase
 * @package MocApi\Tests
 */
abstract class WebApiTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @var \GuzzleHttp\Client $client Guzzle HTTP Client
     */
    protected $client;

    /**
     * Sets up the test environment with a client connected to the api
     */
    public function setUp() {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080/api/',
            'timeout'  => 2.0,
            'http_errors' => false
        ]);
    }

}