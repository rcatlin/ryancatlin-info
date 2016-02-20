<?php

namespace RCatlin\Api\Behavior;

use Refinery29\Piston\Request;

trait ReadsRequestContent
{
    /**
     * @param Request $request
     *
     * @return array|null
     */
    public function readRequestJson(Request $request)
    {
        $content = $request->getBody()->getContents();

        try {
            $json = json_decode($content, true);
        } catch (\Exception $e) {
            return;
        }

        return $json;
    }
}
