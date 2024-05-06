<?php

namespace app\Validation\Rules;

interface ValidationRuleInterface
{
    public function validate($value): bool;
    public function getError(): ?string;
}