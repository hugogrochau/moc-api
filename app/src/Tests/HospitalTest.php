<?php
namespace MocApi\Tests;

/**
 * Class TestHospital
 *
 * @package MocApi\Tests
 */
class TestHospital extends WebApiTestCase {

    /**
    * @test
    */
    public function testGetHospital() {
        $expectedData = json_decode('{"Id":"1","Name":"Hospital Legal","Phone":"21 3333 3333","Timestamp":null}');

        $response = $this->client->get('hospital/1');

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(true));
        $this->assertEquals($data, $expectedData);
    }
}
