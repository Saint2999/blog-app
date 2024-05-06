<?php

namespace app\Validation\Rules;

final class NotNull extends AbstractValidationRule
{
    private $message = 'This value should not be null.';

    public function validate($value): bool
    {
        if ($value === null) {
            $this->error($this->message, ['value' => $value]);

            return false;
        }

        return true;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}