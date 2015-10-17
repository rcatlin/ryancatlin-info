<?php

namespace RCatlin\Blog\Validator;

use Particle\Validator\Validator;

abstract class AbstractValidator extends Validator
{
    /**
     * @var string
     */
    protected $context;
    /**
     * @var array
     */
    protected $values;

    /**
     * @param $context
     * @param array $values
     */
    public function __construct($context, array $values = [])
    {
        parent::__construct();
        $this->context = $context;
        $this->values = $values;
        $this->setup();
    }

    /**
     * Setup required/optional values.
     */
    abstract protected function setup();

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->validate($this->values, $this->context);
    }

    /**
     * @param string $key
     * @param string $name
     * @param bool   $required
     * @param bool   $allowEmpty
     *
     * @return CustomChain
     */
    protected function buildChain($key, $name, $required, $allowEmpty)
    {
        return new CustomChain($key, $name, $required, $allowEmpty);
    }

    /**
     * @param string $key
     * @param string $name
     * @param bool   $required
     * @param bool   $allowEmpty
     *
     * @return CustomChain
     */
    protected function getChain($key, $name, $required, $allowEmpty)
    {
        return parent::getChain($key, $name, $required, $allowEmpty);
    }
}
