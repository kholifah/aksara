<?php

return [
    'title' => 'Store',
    'labels' => [
        'name' => 'Store Name',
        'address' => 'Store Address',
        'phone' => 'Store Phone',
        'all_stores' => 'All Stores',
        'add_store' => 'Add Store',
        'edit_store' => 'Edit Store',
        'store_list' => 'Store List',
        'add_product' => 'Add Product',
    ],
    'messages' => [
        'confirm_delete' => 'Are you sure to delete store?',
        'deleted' => 'Store deleted succesfully',
        'delete_failed' => 'Failed to delete store data',
        'multiple_deleted' => '{1} :count store deleted successfully|[2,*] :count stores deleted successfully',
        'updated' => 'Store updated succesfully',
        'update_failed' => 'Failed to update store data',
        'created' => 'Store created succesfully',
        'create_failed' => 'Failed to create store data',
    ],
    'manager' => [
        'title' => 'Store Manager',
        'labels' => [
            'name' => 'Manager Name',
            'phone' => 'Manager Phone',
            'address' => 'Manager Address',
        ],
        'messages' => [
            'updated' => 'Store Manager updated succesfully',
            'update_failed' => 'Failed to update store manager data',
            'created' => 'Store manager created succesfully',
            'create_failed' => 'Failed to create store manager data',
        ],
    ],
    'product' => [
        'messages' => [
            'add_failed' => 'Failed to add product to store',
            'add_success' => 'Product added to store',
            'delete_failed' => 'Failed to delete product from store',
            'delete_success' => 'Product deleted from store',
        ],
    ],
];
