<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:09
 */

namespace taurus\framework\page;


class AppContainer
{
    /** @var Menu */
    private $menu;

    /** @var  */
    private $breadcrumb;

    /** @var array */
    private $pages;

    /**
     * AppContainer constructor.
     * @param Menu $menu
     * @param $breadcrumb
     * @param array $pages
     */
    public function __construct(Menu $menu, $breadcrumb, array $pages)
    {
        $this->menu = $menu;
        $this->breadcrumb = $breadcrumb;
        $this->pages = $pages;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @return mixed
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * @return array
     */
    public function getPages(): array
    {
        return $this->pages;
    }
}
