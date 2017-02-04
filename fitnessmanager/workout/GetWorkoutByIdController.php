<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:06
 */

namespace fitnessmanager\workout;

use taurus\framework\db\BaseRepository;
use taurus\framework\db\DatabaseManager;
use taurus\framework\HttpGetRequest;
use taurus\framework\routing\Request;

class GetWorkoutByIdController implements HttpGetRequest{

    /** @var DatabaseManager */
    private $workoutBaseRepository;

    /**
     * @param BaseRepository $workoutBaseRepository
     */
    function __construct(BaseRepository $workoutBaseRepository)
    {
        $this->workoutBaseRepository = $workoutBaseRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function handleRequest(Request $request)
    {
        $result = $this->workoutBaseRepository->findOne(1, Workout::class);

        return $result;
    }
}
