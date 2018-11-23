<?php

declare(strict_types=1);

namespace D630\Corg;

class MyException extends \Exception
{
    private $respondMesg;

    public function __construct(
        string $mesg = '',
        int $code = 0,
        bool $respondMesg = false,
        ?\Exception $prev = null
    ) {
        parent::__construct($mesg, $code, $prev);
        $this->respondMesg = $respondMesg;
    }

    public function chooseCode(int $fallback = 500, int ...$codes): int
    {
        foreach ($codes as $v) {
            if ($this->getCode() === $v) {
                return $v;
            }
        }

        return $fallback;
    }

    public function getRespondMesg(): bool
    {
        return $this->respondMesg;
    }
}
