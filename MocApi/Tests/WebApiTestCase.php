<?php
namespace MocApi\Tests;

use Guzzle\Http\Client;

define('PROJECT_ROOT', realpath(__DIR__ . '/../..'));
require_once PROJECT_ROOT . '/vendor/autoload.php';

abstract class WebApiTestCase extends \PHPUnit_Framework_TestCase {

    protected $client;

    public function setUp() {
        $this->client = new Client('http://localhost:8080',
            array(
                'request.options' => array(
                    'exceptions' => false,
            )
        ));
    }

}

?>
