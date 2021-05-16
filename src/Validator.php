<?php
require 'vendor/autoload.php';

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

$string = file_get_contents(__DIR__ . "./data.json");
$json = json_decode($string, true);

function validate($data) {
    v::arrayVal()->each(
        v::keySet(
            v::key("variant_code", v::stringVal()->notEmpty()->length(1, 100)),
            v::key("product_image_id", v::optional(v::intVal())), // This key is missing in the data.json file
            v::key("stock", v::intVal()->notOptional()),
            v::key("price", v::numericVal()->notEmpty()),
            v::key("discount", v::numericVal()->notEmpty()),
            v::key("weight", v::numericVal()->notEmpty()),
            v::key("width", v::numericVal()->notEmpty()),
            v::key("height", v::numericVal()->notEmpty()),
            v::key("longitude", v::numericVal()->notEmpty()),
            v::key("package_weight", v::numericVal()->notEmpty()),
            v::key("package_width", v::numericVal()->notEmpty()),
            v::key("package_longitude", v::numericVal()->notEmpty()),
            v::key("package_height", v::numericVal()->notEmpty())
        )
    )->assert($data);
}

try {
    /*
    $array = [
        [
            "variant_code" => "qwerty"
        ]
    ];
    $result = validate($array);
    */

    validate($json["variants"]);
    echo ("Validation ok");
} catch(NestedValidationException $exception) {
    echo($exception->getFullMessage());
    echo ("Validation error");
}