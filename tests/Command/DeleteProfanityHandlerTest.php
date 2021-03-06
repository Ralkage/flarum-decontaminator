<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\Tests\Decontaminator;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Exception\PermissionDeniedException;
use Flarumite\PostDecontaminator\Command\DeleteProfanity;
use Flarumite\PostDecontaminator\Command\DeleteProfanityHandler;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\Tests\Decontaminator\Stubs\PostDecontaminatorModel;
use Flarumite\Tests\Decontaminator\Traits\ProfanityTestTrait;
use Flarumite\Tests\Decontaminator\Traits\UserTestTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class DeleteProfanityHandlerTest.
 */
final class DeleteProfanityHandlerTest extends AbstractHandlerTest
{
    use UserTestTrait;
    use ProfanityTestTrait;

    public $attributesArray;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->attributesArray = [
            'id'          => 1,
            'name'        => 'Rule',
            'regex'       => '/strawberry/mi',
            'replacement' => 'raspberry',
            'flag'        => true,
            'event'       => false,
        ];
    }

    /**
     * @group unit
     */
    public function testActorWithPermissionCanDeleteProfanity(): void
    {
        $actor = $this->getAdminActor();

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes());

        $command = $this->getMockBuilder(DeleteProfanity::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([1, $actor, $data = [
                'attributes' => $this->attributesArray,
            ]])
            ->getMock();

        $repository = $this->getMockBuilder(PostDecontaminatorRepository::class)
            ->setMethods(['findOrFail'])
            ->getMock();

        $repository->method('findOrFail')
            ->willReturn($this->postDecontaminatorModel->build());

        $settings = $this->createMock(SettingsRepositoryInterface::class);

        $commandHandler = new DeleteProfanityHandler($repository, $settings);

        $profanity = $commandHandler->handle($command);

        $this->assertEquals(array_get($data, 'attributes.id'), $profanity->id);
        $this->assertEquals(array_get($data, 'attributes.name'), $profanity->name);
        $this->assertEquals(array_get($data, 'attributes.regex'), $profanity->regex);
        $this->assertEquals(array_get($data, 'attributes.replacement'), $profanity->replacement);
        $this->assertEquals(array_get($data, 'attributes.flag'), $profanity->flag);
        $this->assertEquals(array_get($data, 'attributes.event'), $profanity->event);
    }

    /**
     * @group unit
     */
    public function testActorWithoutPermissionCannotDeleteProfanityThrowsException(): void
    {
        $this->expectException(PermissionDeniedException::class);

        $actor = $this->getActor();

        $postDecontaminatorModel = $this->createProfanity($actor);

        $command = $this->getMockBuilder(DeleteProfanity::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([1, $actor, $data = [
                'attributes' => $this->attributesArray,
            ]])
            ->getMock();

        $repository = $this->getMockBuilder(PostDecontaminatorRepository::class)
            ->setMethods(['findOrFail'])
            ->getMock();

        $repository->method('findOrFail')
            ->willReturn($postDecontaminatorModel);

        $settings = $this->createMock(SettingsRepositoryInterface::class);

        $commandHandler = new DeleteProfanityHandler($repository, $settings);
        $commandHandler->handle($command);
    }

    /**
     * @group unit
     */
    public function testModelNotFoundExceptionIsThrownIfProfanityDoesNotExist()
    {
        $this->expectException(ModelNotFoundException::class);

        $actor = $this->getAdminActor();

        $command = $this->getMockBuilder(DeleteProfanity::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([1, $actor, $data = [
                'attributes' => $this->attributesArray,
            ]])
            ->getMock();

        $repository = $this->getMockBuilder(PostDecontaminatorRepository::class)
            ->setMethods(['findOrFail'])
            ->getMock();

        $repository->method('findOrFail')
            ->willThrowException(new ModelNotFoundException());

        $settings = $this->createMock(SettingsRepositoryInterface::class);

        $commandHandler = new DeleteProfanityHandler($repository, $settings);
        $commandHandler->handle($command);
    }

    public function getAttributes()
    {
        $response = new PostDecontaminatorModel();
        foreach ($this->attributesArray as $key => $value) {
            $response->$key = $value;
        }

        return $response;
    }
}
