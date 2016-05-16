<?php

namespace App\View;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class View
 * @package App
 * 
 * Концентрируем всю логику по работе с view в одном месте,
 * чтобы было впоследствии проще поменять шаблонизатор
 */
class View
{
    private $templatePath;
    /**
     * @var array
     */
    private $templateVariables;

    /**
     * Возвращает путь до папки с представлениями
     *
     * @param string $fileName
     * @return string
     */
    public static function viewPath(string $fileName = '') : string
    {
        return __DIR__ . '/../../resources/view/' . $fileName;
    }

    /**
     * View constructor.
     * @param string $templatePath
     * @param array $templateVariables
     */
    public function __construct(string $templatePath, array $templateVariables = [])
    {
        $this->templatePath = $templatePath;
        $this->templateVariables = $templateVariables;
    }

    /**
     * Рендерим шаблон
     *
     * @return string
     */
    public function render(): string
    {
        $loader = new Twig_Loader_Filesystem(static::viewPath());
        $twig = new Twig_Environment($loader);

        return $twig->render($this->templatePath, $this->templateVariables);
    }
}