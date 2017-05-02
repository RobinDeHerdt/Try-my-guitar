<?php

return [

    // List of languages this site supports
    'supportedLocales' => [
        'en' => [
            'name'      => 'English',
            'script'    => 'Latn',
            'native'    => 'English',
            'regional'  => 'en_GB'
        ],
        'fr' => [
            'name'      => 'French',
            'script'    => 'Latn',
            'native'    => 'français',
            'regional'  => 'fr_FR'
        ],
        'nl' => [
            'name'      => 'Dutch',
            'script'    => 'Latn',
            'native'    => 'Nederlands',
            'regional'  => 'nl_NL'
        ],
    ],

    // Negotiate for the user locale using the Accept-Language header if it's not defined in the URL?
    // If false, system will take app.php locale attribute
    'useAcceptLanguageHeader' => true,

    // If LaravelLocalizationRedirectFilter is active and hideDefaultLocaleInURL
    // is true, the url would not have the default application language
    //
    // IMPORTANT - When hideDefaultLocaleInURL is set to true, the unlocalized root is treated as the applications default locale "app.locale".
    // Because of this language negotiation using the Accept-Language header will NEVER occur when hideDefaultLocaleInURL is true.
    //
    'hideDefaultLocaleInURL' => false,

    // If you want to display the locales in particular order in the language selector you should write the order here. 
    //CAUTION: Please consider using the appropriate locale code otherwise it will not work
    //Example: 'localesOrder' => ['es','en'],
    'localesOrder' => [],

];
