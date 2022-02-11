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

        if (256 === $this->memory[$this->pointer]) {
            $this->memory[$this->pointer] = 0;
        }
    }

    public function decrement()
    {
        $this->memory[$this->pointer]--;

        if (-1 === $this->memory[$this->pointer]) {
            $this->memory[$this->pointer] = 255;
        }
    }

    public function shiftLeft()
    {
        $this->pointer--;

        if ($this->pointer < 0) {
            $this->pointer = $this->maxMemory - 1;
        }
    }

    public function shiftRight()
    {
        $this->pointer++;

        if ($this->pointer === $this->maxMemory) {
            $this->pointer = 0;
        }
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
