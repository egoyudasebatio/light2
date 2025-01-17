<?php

namespace Light2\Libraries\Light2Validator;

class Validator
{
    public static function validate($input, string $pattern = 'alphanum', int|float $min = 0, int|float $max = 255)
    {
        $options = [
            'options' => [
                'min_range' => $min,
                'max_range' => $max,
            ],
        ];

        $patterns = [
            'alpha' => '/^([a-z])+$/i',
            'alphanum' => '/^([a-z0-9])+$/i',
            'slug' => '/^([-a-z-0-9_-])+$/i',
        ];

        switch ($pattern) {
            case 'bool':
                if (!is_bool($input)) {
                    throw new \Exception("Invalid boolean.");
                }
                break;
            case 'email':
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Invalid email address.");
                }
                break;
            case 'int':
                if (!filter_var($input, FILTER_VALIDATE_INT, $options)) {
                    throw new \Exception("Invalid integer.");
                }
                break;
            case 'float':
                if (!filter_var($input, FILTER_VALIDATE_FLOAT, $options)) {
                    throw new \Exception("Invalid float.");
                }
                break;
            case 'date':
                if (!strtotime($input)) {
                    throw new \Exception("Invalid date.");
                }
                break;
            case 'ip':
                if (!filter_var($input, FILTER_VALIDATE_IP)) {
                    throw new \Exception("Invalid IP address.");
                }
                break;
            case 'url':
                if (!filter_var($input, FILTER_VALIDATE_URL)) {
                    throw new \Exception("Invalid URL.");
                }
                break;
            default:
                if (strlen($input) < $min || strlen($input) > $max) {
                    throw new \Exception("Invalid string length.");
                }

                if (!array_key_exists($pattern, $patterns)) {
                    throw new \Exception("Invalid pattern.");
                }

                if (!preg_match($patterns[$pattern], $input)) {
                    throw new \Exception("Invalid $pattern.");
                }

                break;
        }

        return $input;
    }
}