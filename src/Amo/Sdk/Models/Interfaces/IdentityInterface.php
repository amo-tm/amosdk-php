<?php

namespace Amo\Sdk\Models\Interfaces;

interface IdentityInterface
{
    public function getId(): string;
    public function getType(): string;
}
