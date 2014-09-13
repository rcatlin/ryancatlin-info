<?php

namespace MyProject\Bundle\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MainBundle extends Bundle
{
    public function boot()
    {
        // Register Amazon S3 Client Stream Wrapper
        $this->container->get('aws_s3.client')->registerStreamWrapper();
    }
}
