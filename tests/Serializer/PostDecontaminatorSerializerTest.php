<?php

namespace Flarumite\Tests\Decontaminator\Serializer;

use Flarumite\Tests\Decontaminator\AbstractHandlerTest;
use Flarumite\Tests\Decontaminator\Stubs\MockSerializer;
use Flarumite\Tests\Decontaminator\Stubs\PostDecontaminatorModel;
use Flarumite\Tests\Decontaminator\Traits\ProfanityTestTrait;
use Flarumite\Tests\Decontaminator\Traits\UserTestTrait;
use GuzzleHttp\Psr7\ServerRequest;

class PostDecontaminatorSerializerTest extends AbstractHandlerTest
{
    use UserTestTrait, ProfanityTestTrait;

    public $attributesArray;
    public $now;

    public function setUp(): void
    {
        parent::setUp();
        $this->now = date('Y-m-dH:i:s');
        $this->attributesArray = [
            'id' => 1,
            'name' => 'Rule',
            'regex' => '/strawberry/mi',
            'replacement' => 'raspberry',
            'flag' => true,
            'event' => false,
            'time' => $this->now,
            'edit_time' => $this->now
        ];
    }

    /**
     * @group unit
     */
    public function testNonAdminUserGetsEmptyDataFromSerialiser()
    {
        $actor = $this->getActor();

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes());

        $serverRequestInterface = $this->getMockBuilder(ServerRequest::class)
            ->setConstructorArgs(['GET', '/profanities'])
            ->enableProxyingToOriginalMethods()
            ->getMock();
        $serverRequestInterfaceWithAttributes = $serverRequestInterface->withAttribute('actor', $actor);

        $serializer = new MockSerializer();
        $serializer->setRequest($serverRequestInterfaceWithAttributes);
        $data = $serializer->publicGetDefaultAttributes($this->postDecontaminatorModel->build());

        $this->assertEquals([], $data);
    }

    /**
     * @group unit
     */
    public function testAdminUserReceivesSerialisedData(): void
    {
        $actor = $this->getAdminActor();

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes());

        $serverRequestInterface = $this->getMockBuilder(ServerRequest::class)
            ->setConstructorArgs(['GET', '/profanities'])
            ->enableProxyingToOriginalMethods()
            ->getMock();
        $serverRequestInterfaceWithAttributes = $serverRequestInterface->withAttribute('actor', $actor);

        $serializer = new MockSerializer();
        $serializer->setRequest($serverRequestInterfaceWithAttributes);
        $data = $serializer->publicGetDefaultAttributes($this->postDecontaminatorModel->build());

        $this->assertContains('id', $data);
        $this->assertContains('name', $data);
        $this->assertContains('flag', $data);
        $this->assertContains('event', $data);
        $this->assertContains('replacement', $data);
        $this->assertContains('regex', $data);
        $this->assertContains('time', $data);
        $this->assertContains('editTime', $data);

        $expectedKeys = ['id', 'name', 'flag', 'event', 'replacement', 'regex', 'time', 'editTime'];
        $this->assertEquals($expectedKeys, array_keys($data));

        $this->assertEquals(1, $data['id']);
        $this->assertEquals('Rule', $data['name']);
        $this->assertEquals('/strawberry/mi', $data['regex']);
        $this->assertEquals('raspberry', $data['replacement']);
        $this->assertTrue($data['flag']);
        $this->assertFalse($data['event']);
        $this->assertEquals($this->now, $data['time']);
        $this->assertEquals($this->now, $data['editTime']);
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
