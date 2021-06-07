<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

class BaseRouterComponent extends \CBitrixComponent
{
    /**
     * шаблоны путей по умолчанию
     * @var array
     */
    protected $defaultUrlTemplates404 = [];

    /**
     * Переменные шаблонов путей.
     *
     * @var array
     */
    protected $componentVariables = [];

    /**
     * Cтраница шаблона.
     * @var string
     */
    protected $page = '';

    /**
     * @inheritDoc
     */
    public function executeComponent()
    {
        try {
            $this->setSefDefaultParams();
            $this->getResult();
            $this->includeComponentTemplate($this->page);
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }

    /**
     * Определяет переменные шаблонов и шаблоны путей.
     *
     * @return void
     */
    protected function setSefDefaultParams()
    {
        $this->defaultUrlTemplates404 = [
            'index' => 'index.php',
        ];
        $this->componentVariables = ['ELEMENT_ID'];
    }

    /**
     * Получение результатов.
     *
     * @return void
     */
    protected function getResult()
    {
        $urlTemplates = [];
        if ($this->arParams['SEF_MODE'] === 'Y') {
            $variables = [];
            $urlTemplates = CComponentEngine::MakeComponentUrlTemplates(
                $this->arParams['SEF_URL_TEMPLATES'],
                $this->defaultUrlTemplates404
            );
            $variableAliases = CComponentEngine::MakeComponentVariableAliases(
                $this->defaultUrlTemplates404,
                $this->arParams['VARIABLE_ALIASES']
            );
            $this->page = CComponentEngine::ParseComponentPath(
                $this->arParams['SEF_FOLDER'],
                $urlTemplates,
                $variables
            );

            if (strlen($this->page) <= 0) {
                $this->page = 'index';
            }

            CComponentEngine::InitComponentVariables(
                $this->page,
                $this->componentVariables,
                $variableAliases,
                $variables
            );
        } else {
            $this->page = 'index';
        }

        $this->arResult = [
            'FOLDER' => $this->arParams['SEF_FOLDER'],
            'URL_TEMPLATES' => $urlTemplates,
            'VARIABLES' => $variables,
            'ALIASES' => $variableAliases,
        ];
    }
}
