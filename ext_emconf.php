<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'D3 Visualizations for solr db',
    'description' => 'A widget for rendering some solr statistics.',
    'category' => 'plugin',
    'author' => 'Rainer Schleevoigt, Mirko Klemente',
    'author_company' => 'Staats- und Universitaetsbibliothek Hamburg Carl von Ossietzky',
    'author_email' => 'rainer.schleevoigt@sub.uni-hamburg.de',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '0.1.4',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99'
        ]
    ],
    'autoload' => [
        'psr-4' => [
            'SubHH\\Schaufenster\\' => 'Classes'
        ]
    ],
];
