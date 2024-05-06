<?php

namespace app\Core;

class Response
{
    private string $viewDir;
    private string $view;
    private array $variables = [];

    public function __construct() 
    {
        $this->viewDir = BASE_PATH . '/resources/views';
    }

    public function view(string $name, array $variables = []): void
    {
        $this->addVariables($variables);

        $this->view = $this->viewDir . '/' . $name . '.php';
    }

    public function addVariables(array $variables): void
    {
        $this->variables = array_merge($this->variables, $variables);
    }

    public function render(): void
    {
        if (empty($this->view)) {
            return;
        }

        ob_start();

        extract($this->variables, EXTR_SKIP);

        include $this->view;

        $output = ob_get_clean();

        echo $output;
    }
}