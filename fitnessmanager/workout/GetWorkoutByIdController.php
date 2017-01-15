<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:06
 */

namespace fitnessmanager\workout;

use taurus\framework\db\DatabaseManager;
use taurus\framework\HttpGetRequest;
use taurus\framework\routing\Request;


class GetWorkoutByIdController implements HttpGetRequest{

    /** @var DatabaseManager */
    private $datatabaseManager;

    /**
     * @param DatabaseManager $datatabaseManager
     */
    function __construct(DatabaseManager $datatabaseManager)
    {
        $this->datatabaseManager = $datatabaseManager;
    }

    public function handleRequest(Request $request)
    {
        $result = $this->datatabaseManager->findAll();

        return $result;
    }
}