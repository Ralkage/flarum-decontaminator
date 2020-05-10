<?php

namespace Flarumite\Tests\Decontaminator\Traits;
use Flarumite\Tests\Decontaminator\Stubs\Actor;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserTestTrait
{
    public function getActor()
    {
        $actor = $this->getMockBuilder(Actor::class)
            ->disableOriginalConstructor()
            ->setMethods(['groups', 'can', 'isAdmin'])
            ->getMock();

        $btm = $this->getMockBuilder(BelongsToMany::class)
            ->disableOriginalConstructor()
            ->setMethods(['attach', 'gate'])
            ->getMock();


        $actor->method('groups')
            ->willReturn($btm);

        return $actor;
    }

    public function getAdminActor()
    {
        $actor = $this->getActor();

        $actor->method('can')
            ->with('administrate')
            ->willReturn(true);
        $actor->method('isAdmin')
            ->willReturn(true);

        return $actor;
    }

    public function getEducatorActor()
    {
        $actor = $this->getActor();

        $actor->method('can')
            ->with('educate')
            ->willReturn(true);
        $actor->method('can')
            ->with('administrate')
            ->willReturn(false);

        $actor->method('isAdmin')
            ->willReturn(false);

        return $actor;
    }
}
