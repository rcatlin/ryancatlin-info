<?php

namespace RCatlin\Api\Validator\Entity;

use RCatlin\Api\Validator\AbstractValidator;
use RCatlin\Api\Validator\Context;

class ArticleValidator extends AbstractValidator
{
    private $tagValidator;

    public function __construct(TagValidator $tagValidator)
    {
        parent::__construct();

        $this->tagValidator = $tagValidator;

        $this->context(Context::CREATE, function () {
            $this->addSlug();
            $this->addTitle();
            $this->addContent(true);
            $this->addTags(true);
            $this->addActive();
        });

        $this->context(Context::UPDATE, function () {
            $this->copyContext(Context::CREATE);
        });

        $this->context(Context::PARTIAL_UPDATE, function () {
            $this->addId();
            $this->addSlug(false, false);
            $this->addTitle(false, false);
            $this->addContent(true, false);
            $this->addTags(true, false);
            $this->addActive(false, false);
        });
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return $this
     */
    protected function addId($allowEmpty = false, $required = true)
    {
        return $this->getChain('id', null, $required, $allowEmpty)
            ->integer()
        ;
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return $this
     */
    protected function addSlug($allowEmpty = false, $required = true)
    {
        return $this->getChain('slug', null, $required, $allowEmpty)
            ->isString()
            ->lengthBetween(1, 100)
            ->regex('/^[a-zA-Z\d]+(([_-][A-Za-z\d]+)*)?$/')
        ;
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return $this
     */
    protected function addTitle($allowEmpty = false, $required = true)
    {
        return $this->getChain('title', null, $required, $allowEmpty)
            ->lengthBetween(1, 255)
        ;
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return \RCatlin\Api\Validator\CustomChain
     */
    protected function addContent($allowEmpty = false, $required = true)
    {
        return $this->getChain('content', null, $required, $allowEmpty);
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return $this
     */
    protected function addTags($allowEmpty = false, $required = true)
    {
        return $this->getChain('tags', null, $required, $allowEmpty)
            ->isArray()
            ->embedArray($this->tagValidator, $allowEmpty, $this->context)
        ;
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
     *
     * @return $this
     */
    protected function addActive($allowEmpty = false, $required = true)
    {
        return $this->getChain('active', null, $required, $allowEmpty)
            ->bool()
        ;
    }
}
