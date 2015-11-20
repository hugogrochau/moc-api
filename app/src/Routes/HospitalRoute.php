<?php
namespace MocApi\Routes;

use MocApi\Models\HospitalQuery;
use MocApi\Models\SurgeryformQuery;

/**
 * Class HospitalRoute
 *
 * @package MocApi\Routes
 */

$this->group("/hospital", function () {

    $this->get('/{id}', function ($req, $res, $id) {
        $this->log->info("moc '/api/hospital/$id' route");
        $hospital = HospitalQuery::create()->findPk($id);

        if ($hospital) {
            return $res->write($hospital->toJSON());
        } else {
            return $res->withStatus(404)->write('Hospital not found');
        }
    });

    /*
       SELECT s.name, s.specialty, s.crm FROM hospital AS h
       INNER JOIN hospital_surgeryform AS hsf
       ON h.id = hsf.idHospital
       INNER JOIN surgeryform AS sf
       ON hsf.idsurgeryform = sf.id
       INNER JOIN surgeon_surgeryform AS ssf
       ON sf.id = ssf.idsurgeryform
       INNER JOIN surgeon AS s
       ON ssf.idsurgeon = s.email
       WHERE h.id = $1'; */

    //You must be logged in to use this feature
    //$notLoggedIn($MocApi);
    $this->get('/{id}/surgery/', function ($req, $res, $id) {
        $this->log->info("moc '/api/hospital/$id/surgery/' route");
        $hospital = HospitalQuery::create()->findPk($id);
        $surgeryForms = SurgeryformQuery::create()
            ->filterByHospital($hospital)
            ->joinWithSurgeonSurgeryform()
            ->useSurgeonSurgeryformQuery()
            ->joinWithSurgeon()
            ->useSurgeonQuery()
            ->select(array('Surgeon.Name', 'Surgeon.Crm', 'Surgeon.Specialty'))
            ->find();
        echo $surgeryForms->toJSON();
    });
});

?>