<?php

function generateJWT($dados)
{
    //Application Key
    $key = "ff08e69475562803be134abe13fbd09f27356cfd14944353e789a9afa4661a70"; // loja - exemplo

    //Header Token
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    //Payload - Content
    $payload = [
        'exp' => (new DateTime("now"))->getTimestamp(),
        'uid' => $dados->id,
        'email' => $dados->email,
    ];

    //JSON
    $header = json_encode($header);
    $payload = json_encode($payload);

    //Base 64
    $header = base64_encode($header);
    $payload = base64_encode($payload);

    //Sign
    $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
    $sign = base64_encode($sign);

    //Token
    $token = $header . '.' . $payload . '.' . $sign;
    $x = validJWT($token);
    var_dump($x);

    return $token;
}

function validJWT($token)
{
    $key = 'ff08e69475562803be134abe13fbd09f27356cfd14944353e789a9afa4661a70';

    $partes = explode(".", $token);

    $header = base64_encode($partes[0]);
    $payload = base64_encode($partes[1]);
    $sign = base64_decode($partes[2]);

    $signVerfi = hash_hmac('sha256', $header . "." . $payload, $key, true);

    if ($sign !== $signVerfi) {
        return false;
    }

    //$header = json_encode($header);
    $payload = json_encode($payload);

    return $payload;
}