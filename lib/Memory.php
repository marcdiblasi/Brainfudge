<?php

namespace Brainfudge;

class Memory
{
    protected int $pointer;
    protected array $memory;
    protected int $maxMemory;

    const DEFAULT_MAX_MEMORY = 30000;

    public function __construct(mixed $maxMemory = self::DEFAULT_MAX_MEMORY)
    {
        $this->pointer   = 0;
        $this->maxMemory = $maxMemory ?: self::DEFAULT_MAX_MEMORY;

        $this->memory = array_fill(
            0,
            $this->maxMemory,
            0
        );
    }

    public function increment(): void
    {
        $this->memory[$this->pointer]++;

        if (256 === $this->memory[$this->pointer]) {
            $this->memory[$this->pointer] = 0;
        }
    }

    public function decrement(): void
    {
        $this->memory[$this->pointer]--;

        if (-1 === $this->memory[$this->pointer]) {
            $this->memory[$this->pointer] = 255;
        }
    }

    public function shiftLeft(): void
    {
        $this->pointer--;

        if ($this->pointer < 0) {
            $this->pointer = $this->maxMemory - 1;
        }
    }

    public function shiftRight(): void
    {
        $this->pointer++;

        if ($this->pointer === $this->maxMemory) {
            $this->pointer = 0;
        }
    }

    public function input(int $input): void
    {
        $this->memory[$this->pointer] = $input;
    }

    public function output(): int
    {
        return $this->memory[$this->pointer];
    }
}
