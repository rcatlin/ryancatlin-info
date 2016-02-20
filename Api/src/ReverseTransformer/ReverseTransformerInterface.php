<?php

namespace RCatlin\Api\ReverseTransformer;

interface ReverseTransformerInterface
{
    public function reverseTransform(array $values, $overrideEmbedded = true);

    public function reverseTransformAll(array $multipleValues, $overrideEmbedded = true);
}
