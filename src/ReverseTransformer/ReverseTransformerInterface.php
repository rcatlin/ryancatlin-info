<?php

namespace RCatlin\Blog\ReverseTransformer;

interface ReverseTransformerInterface
{
    public function reverseTransform(array $values, $overrideEmbedded = true);

    public function reverseTransformAll(array $multipleValues, $overrideEmbedded = true);
}
