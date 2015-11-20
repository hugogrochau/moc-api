<?php
namespace MocApi\Tests;

class TestSurgery extends WebApiTestCase {

    /**
    * @test
    */
    public function testGetSurgeries() {
        $this->markTestSkipped(
            'Get surgeries skipped'
        );
        $expectedData = json_decode('{"surgeries":[{"surgeonName":"Dr Jaqueline Sampaio","surgeonSpecialty":"Cardiologista","surgeonCRM":"CRM 172893"},{"surgeonName":"Dr Jo\u00e3o Marcello","surgeonSpecialty":"Hepatologista","surgeonCRM":"CRM 234983"},{"surgeonName":"Dr Felipe Carvalho","surgeonSpecialty":"Neurologista","surgeonCRM":"CRM 12345567"}]}');

        $request = $this->client->get('/api/hospital/5/surgery');
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(true));
        $this->assertEquals($data, $expectedData);
    }
}
