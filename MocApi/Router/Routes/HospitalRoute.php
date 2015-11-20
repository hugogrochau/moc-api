<?php
namespace MocApi\Router\Routes;

use MocApi\Router\Route;
use MocApi\Models\HospitalQuery;
use MocApi\Models\SurgeryformQuery;

class HospitalRoute implements Route {

    public static function route($app) {

        $app->group("/api/hospital", function () use ($app) {

            $app->get('/:id', function ($id) use ($app) {
                $app->log->info("moc '/api/hospital/$id' route");
                $hospital = HospitalQuery::create()->findPk($id);
                if ($hospital) {
                    echo $hospital->toJSON();
                } else {
                    $app->halt(404, 'Hospital not found');
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
            $app->get('/:id/surgery/', function ($id) use ($app) {
                $app->log->info("moc '/api/hospital/$id/surgery/' route");
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

    }
}
?>