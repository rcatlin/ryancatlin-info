<?php

namespace RCatlin\Blog\ReverseTransformer;

interface ReverseTransformerInterface
{
    public function reverseTransform(array $values);

    public function reverseTransformAll(array $multipleValues);
}
