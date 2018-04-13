<?php

return [
    'name' => 'sample-master',
    'title' => 'Aksara Sample Master',
    'description' => 'Sample Master Table Template',

    'providers' => [
        'Plugins\\SampleMaster\\Providers\\SampleMasterServiceProvider',
        'Plugins\\SampleMaster\\Providers\\SupplierServiceProvider',
        'Plugins\\SampleMaster\\Providers\\StoreServiceProvider',
        'Plugins\\SampleMaster\\Providers\\ProductServiceProvider',
    ],

];
