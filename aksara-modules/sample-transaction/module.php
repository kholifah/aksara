<?php

return [
    'name' => 'sample-transaction',
    'title' => 'Aksara Sample Transaction',
    'description' => 'Sample Transaction Table Template',
    'dependencies' => [ 'sample-master' ],

    'providers' => [
        'Plugins\\SampleTransaction\\Providers\\SampleTransactionServiceProvider',
        'Plugins\\SampleTransaction\\Providers\\PurchaseOrderServiceProvider',
    ],

    'aliases' => [
        'ProductPriceCalculator' => 'Plugins\\SampleTransaction\\Facades\\ProductPriceCalculatorFacade',
    ],

];

