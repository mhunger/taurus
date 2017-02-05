<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 21:54
 */

namespace fitnessmanager\workout;


use taurus\framework\db\BaseRepository;
use taurus\framework\http\HttpGetRequest;
use taurus\framework\routing\Request;

/**
 * Class GetAllWorkoutsController
 * @package fitnessmanager\workout
 */
class GetAllWorkoutsController implements HttpGetRequest
{

    /** @var BaseRepository */
    private $baseRepository;

    /**
     * @param BaseRepository $baseRepository
     */
    function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request)
    {
        return $this->baseRepository->findAll(Workout::class);
    }
}