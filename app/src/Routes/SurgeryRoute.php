<?php
namespace MocApi\Routes;

use MocApi\Models\Base\SurgeonSurgery;
use MocApi\Models\SurgeonSurgeryQuery;
use MocApi\Models\SurgeryQuery;
use Propel\Runtime\Map\TableMap;

/**
 * Class SurgeryRoute
 *
 * @package MocApi\Routes
 */

$this->group("/surgery", function () {

    $this->post('/', function ($req, $res) {
        return $res->write(json_encode($req->getParsedBody()));
    });

    $this->get('/', function ($req, $res) {
        $surgery = SurgeryQuery::create()
            ->joinWithCreator()
            ->joinWithSurgeonSurgery()
            ->find();


        if ($surgery) {
            return $res->write($surgery->toJSON());
        } else {
            return $res->withStatus(501)->write('Server Error');
        }
    });

    $this->get('/{id}', function ($req, $res, $id) {
        $result = [];
        $surgery = SurgeryQuery::create()
            ->join('Surgery.Creator')
            ->join('Surgery.SurgeonSurgery')
            ->useSurgeonSurgeryQuery()
                ->join('SurgeonSurgery.Surgeon')
//                ->useSurgeonQuery() TODO join surgeon person with alias
//                    ->join('Surgeon.Person')
//                    ->endUse()
                ->endUse()
            ->findPk($id);

        $patientsArray = [];
        foreach ($surgery->getPatients() as $patient) {
            $patientArray = array_merge($patient->getPerson()->toArray(), $patient->toArray());
            unset($patientArray['PersonId']);
            array_push($patientsArray, $patientArray);
        }

        $surgeonsArray = [];
        foreach ($surgery->getSurgeons() as $surgeon) {
            $surgeonArray = array_merge($surgeon->getPerson()->toArray(), $surgeon->toArray());
            unset($surgeonArray['PersonId']);
            array_push($surgeonsArray, $surgeonArray);
        }

        $result['Surgery'] = $surgery->toArray();
        $result['Surgery']['Creator'] = $surgery->getCreator()->toArray();
        $result['Surgery']['Surgeons'] = $surgeonsArray;
        $result['Surgery']['Patients'] = $patientsArray;
        if ($surgery) {
            return $res->write(json_encode($result));
        } else {
            return $res->withStatus(404)->write('Person not found');
        }
    });
});