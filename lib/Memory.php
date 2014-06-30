<?php

namespace Brainfudge;

class Memory
{
    protected $pointer;
    protected $memory;
    protected $maxMemory;

    const DEFAULT_MAX_MEMORY = 30000;

    public function __construct($maxMemory = self::DEFAULT_MAX_MEMORY)
    {
        $this->pointer   = 0;
        $this->maxMemory = $maxMemory ?: self::DEFAULT_MAX_MEMORY;

        $this->memory = array_fill(
            0,
            $this->maxMemory,
            0
        );
    }

    public function increment()
    {
        $this->memory[$this->pointer]++;
    }

    public function decrement()
    {
        $this->memory[$this->pointer]--;
    }

    public function shiftLeft()
    {
        $this->pointer--;
    }

    public function shiftRight()
    {
        $this->pointer++;
    }

    public function input($input)
    {
        $this->memory[$this->pointer] = (int)$input;
    }

    public function output()
    {
        return $this->memory[$this->pointer];
    }
}
