<?php

if (! function_exists('getPool')) {
    function getPool($type = 'distinct')
    {
        switch ($type) {
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'hexdec':
                $pool = '0123456789abcdef';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
            case 'distinct':
                $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                break;
            default:
                $pool = (string) $type;
                break;
        }

        return $pool;
    }
}

if (! function_exists('secureCrypt')) {
    function secureCrypt($min, $max)
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min; // not so random...
        }

        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }
}

if (! function_exists('getHashedToken')) {
    function getHashedToken($length = 25)
    {
        $token = '';
        $max = strlen(getPool());
        for ($i = 0; $i < $length; $i++) {
            $token .= getPool()[secureCrypt(0, $max)];
        }

        return $token;
    }
}

if (! function_exists('hashArray')) {
    function hashArray($actual, $discard)
    {
        foreach ($actual as $item) {
        }
    }
}

if (! function_exists('createHash')) {
    function createHash($apiKey, $body)
    {
        $hash = '';
        foreach ($body as $key => $val) {
            $hash .= $val;
        }
        $hash = $hash.$apiKey;
        $hash = hash('sha512', $hash);

        return $hash;
    }
}

if (! function_exists('paga')) {
    function paga()
    {
        return app()->make('paga');
    }
}
