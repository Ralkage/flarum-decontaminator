<?php

namespace imorland\PostDecontaminator\Command;

use Flarum\User\AssertPermissionTrait;
use imorland\PostDecontaminator\PostDecontaminatorModel;
use imorland\PostDecontaminator\PostDecontaminatorValidator;

class CreateProfanityHandler
{
    use AssertPermissionTrait;

    protected $validator;


    public function __construct(PostDecontaminatorValidator $validator)
    {
        $this->validator = $validator;
    }


    public function handle(CreateProfanity $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $this->assertAdmin($actor);

        $page = PostDecontaminatorModel::build(
            array_get($data, 'attributes.name'),
            array_get($data, 'attributes.regex'),
            array_get($data, 'attributes.replacement'),
            array_get($data, 'attributes.flag'),
            array_get($data, 'attributes.event')

        );

        $this->validator->assertValid($page->getAttributes());

        $page->save();

        return $page;
    }
}
