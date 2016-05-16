<?php

/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 15.05.16
 * Time: 18:31
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    /**
     * Корректность пути до view
     *
     * @test
     */
    public function it_returns_correct_path()
    {
        $this->assertTrue(file_exists(\App\View\View::viewPath('layout.twig')));
    }
}