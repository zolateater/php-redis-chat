<?php

namespace App\Exception\System;

use Exception;

/**
 * Class UnknownRepositoryType
 * @package App\Exception\System
 * 
 * Системная ошибка - указан неизвестный тип соединения,
 * а это значит, что что-либо сохранить невозможно.
 */
class UnknownRepositoryType extends SystemException
{
    public function __construct(string $repositoryType)
    {
        $this->message = "Unknown repository type - '{$repositoryType}'";
    }

}