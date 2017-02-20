<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:06
 */

namespace fitnessmanager\workout;

use taurus\framework\db\Entity;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

class GetWorkoutByIdController implements Controller
{

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
     * @return Entity
     */
    public function handleRequest(Request $request): Entity
    {
        $result = $this->workoutBaseRepository->findOne(
            $request->getParamByName('id'),
            Workout::class
        );

        return $result;
    }
}
