<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted" => ":attribute zijn nog niet geaccepteerd.",
    "active_url" => ":attribute moet een URL zijn.",
    "after" => ":attribute moet een datum na :date zijn.",
    "alpha" => ":attribute mag alleen letters bevatten.",
    "alpha_dash" => ":attribute mag alleen letters nummers en streepjes bevatten.",
    "alpha_num" => ":attribute mag alleen letters en nummers bevatten.",
    "array" => ":attribute moet een array zijn",
    "before" => ":attribute moet een datum voor :date zijn.",
    "between" => [
        "numeric" => "Het veld :attribute moet tussen :min en :max liggen.",
        "file" => "Het bestand :attribute moet tussen :min en :max kilobytes groot zijn.",
        "string" => "het veld :attribute moet tussen :min en :max karakters bevatten.",
        "array" => "Er moeten tussen :min en :max :attribute gekozen worden.",
    ],
    "boolean" => "Het veld :attribute moet waar of onwaar zijn..",
    "confirmed" => "het veld :attribute moet bevestigd zijn.",
    "date" => "Het veld :attribute bevat geen geldige datum.",
    "date_format" => "Het veld :attribute voldoet niet aan het juiste formaat: :format.",
    "different" => "Het veld :attribute en :other moeten verschillend zijn.",
    "digits" => "The :attribute must be :digits digits.",
    "digits_between" => "The :attribute must be between :min and :max digits.",
    'email' => 'Het :attribute-adres is niet geldig.',
    "filled" => "Het vemd :attribute is verplicht.",
    'exists' => 'Het veld :attribute is niet gekend.',
    'image' => 'Het bestand moet van het type jpeg, png, bmp, of gif zijn.',
    "in" => "Het veld :attribute is niet geldig.",
    "integer" => "Het veld :attribute moet een geheel getal zijn.",
    "ip" => "Het veld :attribute moet een geldig IP addres zijn.",
    "max" => [
        "numeric" => "Het veld :attribute mag niet groter zijn dan :max.",
        "file" => "Het veld :attribute mag niet groter zijn dan :max kilobytes.",
        "string" => "Het veld :attribute  mag niet langer zijn dan :max karakters.",
        "array" => "Het veld :attribute mag niet meer dan :max items bevatten.",
    ],
    "mimes" => "Het :attribute moet een bestand zijn van het type: :values.",
    "min" => [
        "numeric" => "Het veld :attribute mag niet kleiner zijn dan :min.",
        "file" => "Het veld :attribute mag niet kleiner zijn dan :min kilobytes.",
        "string" => "Het veld :attribute mag niet korter zijn dan :min karakters.",
        "array" => "Het veld :attribute mag niet minder dan :min items bevatten.",
    ],
    "not_in" => "Het geselecteerde :attribute is ongeldig.",
    'numeric' => 'Het veld :attribute mag enkel nummers bevatten.',
    "regex" => "Het veld :attribute voldoet niet aan het gevraagde formaat.",
    "required" => "het veld :attribute is verplicht.",
    "required_if" => "Het :attribute is verplicht als :other :value is.",
    "required_with" => "Het veld :attribute is verplicht als :values aanwezig is.",
    "required_with_all" => "Het veld :attribute is verplicht als :values aanwezig zijn.",
    "required_without" => "Het veld :attribute is verplicht als :values niet aanwezig is.",
    "required_without_all" => "Het veld :attribute is verplicht als geen van :values aanwezig zijn.",
    'same' => 'Het veld :attribute moet gelijk zijn aan het veld :other.',
    "size" => [
        "numeric" => "Het veld :attribute moet :size zijn.",
        "file" => "Het veld :attribute moet :size kilobytes zijn.",
        "string" => "Het veld :attribute moet :size karakters bevatten.",
        "array" => "Het veld :attribute moet :size items bevatten.",
    ],
    'unique' => 'Het veld :attribute bestaat al in onze database.',
    "url" => "Het veld :attribute is geen geldige url.",
    "timezone" => "Het veld :attribute moet een geldige tijdzone bevatten.",


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];