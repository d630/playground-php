<?php
namespace bestellando;

class Template
{
    private $base;
    private $page;

    public function __construct($base)
    {
        $this->base = $base;
    }

    public function render($page, $data = [])
    {
        foreach ($data as $k => $v) {
            // crazy
            $this->{$k} = $v;
        }

        $this->page = $page;
        require $this->base;
    }

    public function content()
    {
        require $this->page;
    }
}
?>
