<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

use Flarumite\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer;

class MockSerializer extends PostDecontaminatorSerializer
{
    public function publicGetDefaultAttributes($page){
        return parent::getDefaultAttributes($page);
    }
}
