<?php

declare(strict_types=1);

namespace D630\Corg\Response;

interface ResponseInterface
{
    public function connect(): void;

    public function delete(): void;

    public function get(): void;

    public function head(): void;

    public function options(): void;

    public function post(): void;

    public function put(): void;

    public function trace(): void;
}
