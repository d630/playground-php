<?php

declare(strict_types=1);

namespace D630\Corg\Router\Dispatcher;

class ClassCall implements DispatcherInterface
{
    private $controllerName;
    private $controllerSettings;
    private $modelNames;

    public function __construct(array $settings, array $classNames)
    {
        $this->controllerSettings = $settings;

        // if (\count($classNames) !== 2 || \count($classNames) !== 3) {
        //     throw new \Exception('invalid controller/model config', 500);
        // }

        if (!\count($classNames[1])) {
            throw new \Exception('need model/method pair', 500);
        }

        $this->controllerName = $classNames[0];
        $this->modelNames = $classNames[1];
    }

    public function dispatch(array $options = []): void
    {
        foreach ($this->modelNames as $k => $v) {
            [$model, $modelMethod] = $this->parse($v);
            $this->modelNames[$k] =
                (new $model(@$this->controllerSettings['for']))
                    ->{$modelMethod}();
        }

        [$controller, $controllerMethod] = $this->parse($this->controllerName);
        $callable = [
            new $controller($this->modelNames, $this->controllerSettings, $options),
            $controllerMethod,
        ];
        $callable();
    }

    private function parse(string $className): array
    {
        return explode('::', $className);
    }
}
