<?php

namespace RCatlin\Blog\Validator\Rule;

use Particle\Validator\Rule;
use Particle\Validator\Validator;

class EmbeddedValidatorRule extends Rule
{
    const NOT_ARRAY = 'EMBEDDEDVALIDATOR::NOT_AN_ARRAY';
    const NOT_VALID = 'EMBEDDEDVALIDATOR::NOT_VALID';
    const CANNOT_BE_EMPTY = 'EMBEDDEDVALIDATOR::CANNOT_BE_EMPTY';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_ARRAY => '{{ name }} must be an array to be validated.',
        self::NOT_VALID => '{{ name }} failed validation.',
        self::CANNOT_BE_EMPTY => '{{ name }} cannot be an empty array.',
    ];

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var string
     */
    private $context;

    private $allowEmpty;

    /**
     * @param Validator $validator
     * @param string    $context
     * @param bool      $allowEmpty
     */
    public function __construct(Validator $validator, $context, $allowEmpty = false)
    {
        $this->validator = $validator;
        $this->context = $context;
        $this->allowEmpty = $allowEmpty;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value)
    {
        if (!is_array($value)) {
            return $this->error(self::NOT_ARRAY);
        }

        if (!$this->allowEmpty && empty($value)) {
            return $this->error(self::CANNOT_BE_EMPTY);
        }

        if ($this->validator->validate($value, $this->context)->isNotValid()) {
            return $this->error(self::NOT_VALID);
        }

        return true;
    }
}
