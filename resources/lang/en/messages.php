<?php

return [
    'empty' => 'There Is Nothing To Be Displayed Here',
    'success' => 'Request was successful',
    'success_title' => 'Success!!',
    'empty_description' => 'There is no description for this product',
    'empty_instructions' => 'There were no usage instructions provided for this product',
    'empty_notes' => 'There is no additional information provided',
    'validation' => [
        'suppliers' => [
            'required' => 'Please choose a supplier from the dropdown',
            'after' => 'The drug seems to have already expired',
            'url' => 'The url provided is not valid',
        ],
    ],
    'stock_updated' => 'The stock with reference :ref has been updated successfully',
    'config_add_ok' => 'Configuration setting was successfully created',
    'lpo_notes' => 'Any additional information or notes to the Supplier',
    'lpo_created' => 'A new Purchase order has been created',
    'product_sold' => 'Item was sold',
    'add_product' => 'Item was added for the first time',
    'add_stock' => 'Product stock was added',
    'contact_created' => 'A new :supplier contact has been created',
    'contact_updated' => 'Contact details has been updated',
    'contact_deleted' => 'The Contact has been deleted',
    'acl_update' => 'Access and control permissions has been updated',
    'attach_role' => 'Please Attach a role to a user',
    'loging' => [
        'add_stock' => 'updated the stock level for :product to :qty, Transaction reference is :ref',
        'logout_event' => 'Loged out of the application from :ip at :time',
        'login_event' => 'Authenticated into the application dashboard from :ip at :time',
        'failed_login_event' => 'Failed log in attempt to this account from :ip at :time ',
        'user_create_event' => 'Created a new user account for :name on :time',
        'edit_product' => 'Product details for :product was upadted',
        'add_product' => 'Added a new product :product to the stock records',
    ],
];
