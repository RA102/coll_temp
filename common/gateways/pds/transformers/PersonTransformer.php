<?php

namespace common\gateways\pds\transformers;

use common\gateways\pds\dto\PersonCredentialResponse;
use common\gateways\pds\dto\PersonResponse;
use Karriere\JsonDecoder\Bindings\FieldBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class PersonTransformer implements Transformer
{
    public function register(ClassBindings $classBindings)
    {
        $classBindings->register(new FieldBinding('cred', 'cred', PersonCredentialResponse::class));
    }

    public function transforms()
    {
        return PersonResponse::class;
    }
}