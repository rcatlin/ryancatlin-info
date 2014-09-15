<?php

namespace MyProject\Bundle\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Aws\S3\S3Client;

/**
 * Corrects Content-type header values in an s3 bucket folder.
 *  - Ensures *.js files have a content-type set to 'application/javascript'.
 *  - Ensures *.css files have a content-type set to 'text/css'.
 *
 * @author Ryan Catlin <ryan.catlin@gmail.com
 */
class FixS3ContentTypesCommand extends ContainerAwareCommand
{
    const NAME = 's3:fix-content-types';
    const CONTENT_TYPE_CSS = 'text/css';
    const CONTENT_TYPE_JS = 'application/javascript';

    public function configure()
    {
        $this
            ->setName($this->getName())
            ->addArgument('client-service', InputArgument::REQUIRED, 'The container service id of the AWS S3 Client')
            ->addArgument('bucket', InputArgument::REQUIRED, 'Bucket name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $clientServiceId = $input->getArgument('client-service');
        $bucket = $input->getArgument('bucket');

        // Get Client service
        try {
            $client = $this->getContainer()->get($clientServiceId);
        } catch (ServiceNotFoundException $e) {
            $output->writeln(
                sprintf(
                    '<error>Client service with id "%s" not found.</error>',
                    $clientServiceId
                )
            );

            return;
        }

        if (!($client instanceof S3Client)) {
            $output->writeln('Incorrect client service type');

            return;
        }

        // Verify bucket exists
        if (!$client->doesBucketExist($bucket)) {
            $output->writeln(
                sprintf(
                    '<error>Bucket "%s" does not exists.</error>',
                    $bucket
                )
            );

            return;
        }

        $output->writeln(
            sprintf(
                'Iterating over all objects in bucket <comment>%s</comment>',
                $bucket
            )
        );

        // Get Objects Iterator
        $objects = $client->getIterator(
            'ListObjects',
            array(
                'Bucket' => $bucket,
            )
        );

        // Iterate over objects
        foreach ($objects as $listing) {
            $key = $listing['Key'];

            if ($this->isKeyJs($key)) {
                // Javascript file
                $contentType = self::CONTENT_TYPE_JS;
                $type = 'js';
            } elseif ($this->isKeyCss($key)) {
                // CSS file
                $contentType = self::CONTENT_TYPE_CSS;
                $type = 'css';
            } else {
                // Skip other
                continue;
            }

            // Retrieve Object
            $object = $client->getObject(
                array(
                    'Bucket' => $bucket,
                    'Key' => $key,
                )
            );

            // Skip if content type is correct
            if (isset($object['ContentType']) && $contentType === $object['ContentType']) {
                $output->writeln(
                    sprintf(
                        '<comment>%s</comment> <info>[%s]</info> Valid Content-Type: <comment>%s</comment>',
                        date('H:i:s'),
                        $type,
                        $key
                    )
                );
                continue;
            }

            // Get Object's body
            $body = (string) $object['Body'];

            // Upload object with Content-Type
            $client->putObject(
                array(
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'Body' => $body,
                    'ContentType' => $contentType,
                )
            );

            $output->writeln(
                sprintf(
                    '<comment>%s</comment> <info>[%s+]</info> Fixing %s',
                    date('H:i:s'),
                    $type,
                    $key
                )
            );
        }
    }

    private function isKeyCss($key)
    {
        return (substr($key, '-4') === '.css');
    }

    private function isKeyJs($key)
    {
        return (substr($key, '-3') === '.js');
    }

    public function getName()
    {
        return self::NAME;
    }
}
