<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:30
 */

namespace taurus\framework\page;


use fitnessmanager\workout\Workout;
use taurus\framework\api\ApiBuilder;

class AppContainerBuilder
{

    /** @var ApiBuilder */
    private $apiBuilder;

    public function __construct(ApiBuilder $apiBuilder)
    {
        $this->apiBuilder = $apiBuilder;
    }

    /**
     * @param AppConfig $appConfig
     * @return AppContainer
     */
    public function build(AppConfig $appConfig): AppContainer
    {

        $listComponent = new ListComponent(
            $this->apiBuilder->cget(Workout::class),
            Workout::class
        );

        $items = [];
        foreach ($appConfig->getMenuItems() as $item) {
            $items[] = new MenuItem($item->name, $item->path, $listComponent);
        }

        $menu = new Menu($appConfig->getMenu()->name, $appConfig->getMenu()->type, $items);


        return new AppContainer($menu, new BreadCrumb(), [$listComponent]);
    }
}