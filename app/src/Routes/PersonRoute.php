<?php
namespace MocApi\Routes;

use MocApi\Models\PersonQuery;

/**
 * Class PersonRoute
 *
 * @package MocApi\Routes
 */

$this->group("/person", function () {
    $this->get('/', function ($req, $res) {
        $person = PersonQuery::create()->find();

        if ($person) {
            return $res->write($person->toJSON());
        } else {
            return $res->withStatus(501)->write('Server Error');
        }
    });

    $this->get('/{id}', function ($req, $res, $id) {
        $person = PersonQuery::create()->findPk($id);

        if ($person) {
            return $res->write($person->toJSON());
        } else {
            return $res->withStatus(404)->write('Person not found');
        }
    });
});