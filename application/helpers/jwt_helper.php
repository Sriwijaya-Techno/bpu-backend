<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function encode_jwt($payload)
{
    $key = '123qweAS';
    $jwt = JWT::encode($payload, $key, 'HS256');

    return $jwt;
}

function decode_jwt($token)
{
    $key = '123qweAS';

    try {
        $data_decoded = JWT::decode($token, new Key($key, 'HS256'));
        $data_jwt['status'] = 'Success';
        $data_jwt['data'] = $data_decoded;
    } catch (Exception $ex) {
        $data_jwt['status'] = 'Error';
        $data_jwt['pesan'] = $ex->getMessage();
    }

    return $data_jwt;
}
