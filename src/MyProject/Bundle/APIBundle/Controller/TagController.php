<?php

namespace MyProject\Bundle\APIBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Tag controller.
 *
 * @Route("/api/tags")
 */
class TagController extends BaseController
{
    /**
     * Lists all Tag entities.
     *
     * @Route("/names", name="api_list_all_tags")
     * @Method("GET")
     */
    public function listAllNamesAction()
    {
        $tags = $this->getTagRepository()->findAllNames();

        if (!$tags || empty($tags)) {
            return $this->returnJson([]);
        }

        return $this->returnJson(
            array_map(
                function ($tag) {
                    if (!isset($tag['name'])) {
                        return;
                    }

                    return $tag['name'];
                },
                $tags
            )
        );
    }
}
