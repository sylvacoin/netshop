<?php

$config = array(
    'signup' => array(
        array(
            'field' => 'fname',
            'label' => 'Full Name',
            'rules' => 'required|min_length[6]',
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone number',
            'rules' => 'required',
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|is_unique[Users.email]',
            'errors' => array(
                'is_unique' => 'This %s already exists please choose another',
            ),
        ),
        array(
            'field' => 'pswd',
            'label' => 'Password',
            'rules' => 'required',
        ),
        array(
            'field' => 'pswd2',
            'label' => 'Password Confirmation',
            'rules' => 'required|matches[pswd]',
        ),
    ),
    'profile' => array(
        array(
            'field' => 'fname',
            'label' => 'First Name',
            'rules' => 'required',
        ),
        array(
            'field' => 'lname',
            'label' => 'Last Name',
            'rules' => 'required',
        ),
        array(
            'field' => 'uname',
            'label' => 'User Name',
            'rules' => 'required',
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone number',
            'rules' => 'required',
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required',
            'errors' => array(
                'is_unique' => 'This %s already exists please choose another',
            ),
        ),
    ),
    'login' => array(
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|callback_authenticate',
        ),
        array(
            'field' => 'pswd',
            'label' => 'Password',
            'rules' => 'required',
        ),
    ),
    'alogin' => array(
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|callback_authenticate_admin',
        ),
        array(
            'field' => 'pswd',
            'label' => 'Password',
            'rules' => 'required',
        ),
    ),
    'recovery' => array(
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|callback_validate_email',
        ),
    ),
    'categories' => array(
        array(
            'field' => 'category',
            'label' => 'Category name',
            'rules' => 'required',
        ),
        array(
            'field' => 'icon',
            'label' => 'Icon',
            'rules' => 'required',
        ),
    ),
    'exlocations' => array(
        array(
            'field' => 'location',
            'label' => 'Location name',
            'rules' => 'required',
        )
    ),
    'products' => array(
        array(
            'field' => 'product',
            'label' => 'Product name',
            'rules' => 'required',
        ),
        array(
            'field' => 'price',
            'label' => 'Product price',
            'rules' => 'required',
        ),
        array(
            'field' => 'category',
            'label' => 'Product category',
            'rules' => 'required',
        ),
    ),
    'transaction' => array(
        array(
            'field' => 'amount',
            'label' => 'Amount',
            'rules' => 'required',
        ),
    ),
    'transfer2' => array(
        array(
            'field' => 'transID',
            'label' => 'Transfer ID',
            'rules' => 'required|callback_authenticate_transfer',
        ),
    ),
    'analytics' => array(
        array(
            'field' => 'item',
            'label' => 'item',
            'rules' => 'required',
        ),
        array(
            'field' => 'id',
            'label' => 'Product ID',
            'rules' => 'required',
        ),
    ),
);
