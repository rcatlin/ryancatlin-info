<?php

namespace RCatlin\Blog\Test\Unit\Serializer\Transformer\Entity;

use RCatlin\Blog\Entity;

class ArticleStub extends Entity\Article
{
    /**
     * @var \DateTime
     */
    private $currentDateTime;

    /**
     * @param \DateTime $currentDateTime
     */
    public function __construct(\DateTime $currentDateTime)
    {
        $this->setCurrentDateTime($currentDateTime);
        parent::__construct();
    }

    /**
     * @return \DateTime
     */
    protected function getCurrentDateTime()
    {
        return $this->currentDateTime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setCurrentDateTime(\DateTime $datetime)
    {
        $this->currentDateTime = $datetime;
    }
}
