<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nome del campo del database
    |--------------------------------------------------------------------------
    |
    | Qui è possibile specificare il nome del campo in cui vengono salvati gli stati
    |
    |
    */
    'column' => 'status',

    /*
    |--------------------------------------------------------------------------
    | Valori degli stati del flusso base
    |--------------------------------------------------------------------------
    |
    | Qui è possibile specificare per i tre stati fondamentali draft, published, unpublished
    | il valore da inserire all'interno del campo del database
    |
    */
    'status' => [
        'draft' => 'draft',
        'published' => 'published',
        'unpublished' => 'unpublished'
    ],

    /*
    |--------------------------------------------------------------------------
    | Usa una data di pubblicazione
    |--------------------------------------------------------------------------
    |
    | Nel caso sia necessaria una data di pubblicazione allora abilitare questa opzione impostando
    | Active su True
    |
    |
    |
    */
    'publication_date' => [
        'active' => true,
        'column' => 'published_at', //Nome del campo
        'auto_save_on_published' => false //Quando lo stato passa in pubblicato automaticamente viene riempita la data di pubblicazione con la data corrente
    ],
];
