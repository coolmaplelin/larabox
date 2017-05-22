<?php

return array(


    'pdf' => array(
        'enabled' => true,
        //'binary'  => '/usr/local/bin/wkhtmltopdf',
        //'binary' => 'C:\DEV\wkhtmltopdf\bin\wkhtmltopdf',
        'binary' =>  env('PDF_BINARY'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        //'binary'  => '/usr/local/bin/wkhtmltoimage',
        //'binary' => 'C:\DEV\wkhtmltopdf\bin\wkhtmltoimage',
        'binary' =>  env('PDF_BINARY_IMAGE'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
