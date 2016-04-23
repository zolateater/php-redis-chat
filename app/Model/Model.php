<?php

namespace App\Model;

/**
 * Class Model
 * @package App\Model
 * 
 * Базовый класс для моделей
 */
abstract class Model
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }


}