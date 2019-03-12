<?php

namespace common\gateways\pds\transformers;

use common\gateways\pds\dto\LoginResponse;
use common\gateways\pds\dto\PersonResponse;
use Karriere\JsonDecoder\Bindings\FieldBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class LoginTransformer implements Transformer
{
    public function register(ClassBindings $classBindings)
    {
        $classBindings->register(new FieldBinding('person', 'person', PersonResponse::class));
    }

    public function transforms()
    {
        return LoginResponse::class;
    }
}