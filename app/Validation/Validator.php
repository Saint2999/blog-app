<?php

namespace app\Validation;

use app\Validation\Rules\ValidationRuleInterface;

final class Validator
{
    private array $rules;

    private array $errors = [];

    private array $data = [];

    public function __construct(array $fieldRules)
    {
        foreach ($fieldRules as $field => $rules) {
            if (!is_array($rules)) {
                $rules = [$rules];
            }

            $this->addRules($field, $rules);
        }
    }

    public function validate(array $data): bool
    {
        $this->data = $data;

        foreach ($this->rules as $field => $rules) {
            if (!isset($this->data[$field])) {
                $this->data[$field] = null;
            }

            foreach ($rules as $rule) {
                if ($rule->validate($this->data[$field]) === false) {
                    $this->addError($field, (string)$rule->getError());
                }
            }
        }

        return $this->getErrors() === [];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    private function addRules(string $field, array $rules): void
    {
        foreach ($rules as $rule) {
            if (!$rule instanceof ValidationRuleInterface) {
                throw new \InvalidArgumentException(sprintf(
                    $field . ' rule must be an instance of ValidationRuleInterface, "%s" given.',
                    is_object($rule) ? get_class($rule) : gettype($rule)
                ));
            }

            $this->rules[$field][] = $rule;
        }
    }
}