<?php

namespace RCatlin\Blog\Validator\Rule;

use Assert\Assertion;
use Particle\Validator\Rule;
use Particle\Validator\Validator;

class EmbeddedArrayValidatorRule extends Rule
{
    const NOT_ARRAY = 'EMBEDDEDARRAYVALIDATOR::NOT_ARRAY';
    const ARRAY_CANNOT_BE_EMPTY = 'EMBEDDEDARRAYVALIDATOR::ARRAY_CANNOT_BE_EMPTY';
    const ARRAY_ITEM_NOT_VALID = 'EMBEDDEDARRAYVALIDATOR::ARRAY_ITEM_NOT_VALID';
    const ARRAY_ITEM_NOT_ARRAY = 'EMBEDDEDARRAYVALIDATOR::ARRAY_ITEM_NOT_ARRAY';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_ARRAY => '{{ name }} must be an array to be validated.',
        self::ARRAY_CANNOT_BE_EMPTY => '{{ name }} cannot be an empty array.',
        self::ARRAY_ITEM_NOT_VALID => '{{ name }} failed validation on one of it\'s items.',
        self::ARRAY_ITEM_NOT_ARRAY => '{{ name }} has a non-array item.',
    ];

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var string
     */
    private $context;

    /**
     * @var bool
     */
    private $allowEmpty;

    /**
     * @param Validator $validator
     * @param $context
     * @param bool $allowEmpty
     */
    public function __construct(Validator $validator, $context, $allowEmpty = false)
    {
        Assertion::string($context);
        Assertion::boolean($allowEmpty);

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
            return $this->error(self::ARRAY_CANNOT_BE_EMPTY);
        }

        foreach ($value as $item) {
            if (!is_array($item)) {
                return $this->error(self::ARRAY_ITEM_NOT_ARRAY);
            }

            if ($this->validator->validate($item, $this->context)->isNotValid()) {
                return $this->error(self::ARRAY_ITEM_NOT_VALID);
            }
        }

        return true;
    }
}
