<?php

namespace Brainfudge;

class Parser
{
    protected $memory;

    protected $code;
    protected $input;

    protected $codePointer;

    public function __construct($code, $input = '', $maxMemory = null)
    {
        $this->code  = $code;
        $this->input = $input;

        $this->codePointer = 0;

        $this->memory = new \Brainfudge\Memory($maxMemory);
    }

    public function run()
    {
        $output = '';
        $plan = '';

        while (true) {
            $action = $this->nextAction();
            if (false === $action) {
                break;
            }

            $plan .= $action;

            if ('<' === $action) {
                $this->memory->shiftLeft();
            } elseif ('>' === $action) {
                $this->memory->shiftRight();
            } elseif ('-' === $action) {
                $this->memory->decrement();
            } elseif ('+' === $action) {
                $this->memory->increment();
            } elseif ('.' === $action) {
                $byte = $this->memory->output();

                $output .= chr($byte);
            } elseif (',' === $action) {
                if (0 === strlen($this->input)) {
                    $this->memory->input(0);

                    break;
                }

                $character = $this->input[0];
                $this->memory->input($character);

                if (1 === strlen($this->input)) {
                    $this->input = '';
                } else {
                    $this->input = substr($this->input, 1);
                }
            } elseif ('[' === $action) {
                if (0 === $this->memory->output()) {
                    $found = $this->findLoopClose();

                    if (!$found) {
                        throw new \Exception('Error: Missing a "]"');
                    }
                }
            } elseif (']' === $action) {
                if (0 !== $this->memory->output()) {
                    $found = $this->findLoopOpen();

                    if (!$found) {
                        throw new \Exception('Error: Missing a "["');
                    }
                }
            }

            $this->codePointer++;
        }

        return $output;
    }

    protected function nextAction()
    {
        static $commands = ['<', '>', '-', '+', '.', ',', '[', ']'];
            
        if (!isset($this->code[$this->codePointer])) {
            return false;
        }

        while (!in_array($this->code[$this->codePointer], $commands)) {
            if ($this->codePointer + 1 >= strlen($this->code)) {
                return false;
            }

            $this->codePointer++;
        }

        return $this->code[$this->codePointer];
    }

    protected function findLoopOpen()
    {
        $depth = 0;

        while ('[' !== $this->code[--$this->codePointer] || 0 !== $depth) {
            if ($this->codePointer < 0) {
                return false;
            }

            if (']' === $this->code[$this->codePointer]) {
                $depth++;
            } elseif ('[' === $this->code[$this->codePointer]) {
                $depth--;
            }
        }

        return true;
    }

    protected function findLoopClose()
    {
        $depth = 0;

        while (']' !== $this->code[++$this->codePointer] || 0 !== $depth) {
            if ($this->codePointer >= strlen($this->code)) {
                return false;
            }

            if ('[' === $this->code[$this->codePointer]) {
                $depth++;
            } elseif (']' === $this->code[$this->codePointer]) {
                $depth--;
            }
        }

        return true;
    }
}
