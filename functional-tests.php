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
    [
        'code'   => '+[-->-[>>+>-----<<]<--<---]>-.>>>+.>>..+++[.>]<<<<.+++.------.<<-.>>>>+.',
        'input'  => '',
        'output' => 'Hello World!',
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
    } else {
        echo 'Test ' . $number . ' passed.' . PHP_EOL;
    }

    $number++;
}
