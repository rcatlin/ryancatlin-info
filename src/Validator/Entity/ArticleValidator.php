<?php

namespace RCatlin\Blog\Validator\Entity;

use RCatlin\Blog\Validator\AbstractValidator;
use RCatlin\Blog\Validator\Context;

class ArticleValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct();

        $this->context(Context::CREATE, function () {
            $this->addSlug();
            $this->addTitle();
            $this->addContent(true);
            $this->addTags(true);
            $this->addActive(true, false);
        });

        $this->context(Context::UPDATE, function () {
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
            ->lengthBetween(1, 100)
            ->alnum()
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
     * @return \RCatlin\Blog\Validator\CustomChain
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
