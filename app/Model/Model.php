<?php

namespace App\Model;

/**
 * Class Model
 * @package App\Model
 * 
 * Базовый класс для моделей c id
 */
abstract class Model
{
    /**
     * <философия>
     * 0 означает отсутствие Id
     * Просто примите это.
     * Ноль - это ничто.
     * Id равный нулю означает его отсутствие.
     * </философия>
     * 
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