<?php

declare(strict_types=1);

namespace D630\Corg\Model;

class Model implements ModelInterface
{
    private $for;
    private $ns;

    public function __construct(string $ns, string $for)
    {
        $this->ns = $ns;
        $this->for = $for;
    }

    public function build()
    {
        $factory = $this->ns . '\\Request\\RequestFactory';
        $for = 'create' . $this->for . 'Request';

        if (!method_exists($factory, $for)) {
            throw new \Exception('for is not a request method: ' . $factory . ', ' . $for, 400);
        }

        return (new $factory())->{$for}($this->ns . '\\Request');
    }
}
