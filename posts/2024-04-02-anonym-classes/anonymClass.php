<?php

$data = ['zero', 'one', 'two'];

return new class($data)
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($idx)
    {
        return $this->data[$idx];
    }
};
