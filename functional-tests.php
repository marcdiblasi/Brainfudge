<?php

$tests = [
    [
        'code'   => '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++.',
        'input'  => '',
        'output' => 'A',
    ],
    [
        'code'   => '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-+-+><.',
        'input'  => '',
        'output' => 'A',
    ],
    [ // Check for integer out of bounds handling
        'code'   => '-.',
        'input'  => '',
        'output' => chr(255),
    ],
    [ // Check for pointer overflow
        'code'   => '+<.',
        'input'  => '',
        'output' => chr(0),
    ],
    [ // Simple Addition
        'code'   => ',>,<[->+<]>.',
        'input'  => chr(2) . chr(5),
        'output' => chr(7),
    ],
    [
        'code'   => '+++++++++[>++++++++<-]>.<+++[>+++++++++++<-]>.[-]<+++[>+++++++++++<-]>.',
        'input'  => '',
        'output' => 'Hi!',
    ],
    [
        'code'   => '+[-->-[>>+>-----<<]<--<---]>-.>>>+.>>..+++[.>]<<<<.+++.------.<<-.>>>>+.',
        'input'  => '',
        'output' => 'Hello, World!',
    ],
    [ // reverse
        'code'   => '+[>,]<-[+.<-]',
        'input'  => 'reverse',
        'output' => 'esrever',
    ]
];

require_once __DIR__ . '/lib/Memory.php';
require_once __DIR__ . '/lib/Parser.php';

$number = 1;
foreach ($tests as $test) {
    $parser = new \Brainfudge\Parser($test['code'], $test['input']);

    $output = $parser->run();

    if ($output !== $test['output']) {
        echo 'Test ' . $number . ' failed.' . PHP_EOL;
        echo PHP_EOL;
        echo 'Should be "' . $test['output'] . '"' . PHP_EOL;
        echo 'Returned "' . $output . '" ("' . bin2hex($output) . '")' . PHP_EOL;
        echo PHP_EOL;
    } else {
        echo 'Test ' . $number . ' passed.' . PHP_EOL;
    }

    $number++;
}
