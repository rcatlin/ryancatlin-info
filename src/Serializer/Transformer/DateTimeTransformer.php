<?php

namespace RCatlin\Blog\Serializer\Transformer;

use League\Fractal\TransformerAbstract;

class DateTimeTransformer extends TransformerAbstract
{
    // Example: '2015-09-07 21:00:19 -04:00'
    const FORMAT = 'Y-m-d H:i:s P';

    /**
     * @param \DateTime $datetime
     *
     * @return array
     */
    public function transform(\DateTime $datetime)
    {
        return [
            'timestamp' => $datetime->getTimestamp(),
            'formatted' => $datetime->format(self::FORMAT),
        ];
    }
}
