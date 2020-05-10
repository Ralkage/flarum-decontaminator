<?php

namespace Flarumite\Tests\Decontaminator;

use Flarum\Discussion\Discussion;
use Flarum\Extension\ExtensionManager;
use Flarum\Post\Post;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\Tests\Decontaminator\Stubs\MockDiscussion;
use Flarumite\Tests\Decontaminator\Stubs\MockPost;
use Flarumite\Tests\Decontaminator\Stubs\MockPostDecontaminatorModel;
use Flarumite\Tests\Decontaminator\Traits\UserTestTrait;
use Illuminate\Contracts\Bus\Dispatcher;

class DecontaminationProcessorTest extends AbstractHandlerTest
{
    use UserTestTrait;

    /**
     * @var DecontaminationProcessor
     */
    public $decontaminationProcessor;

    public $model;

    public $attributesArray;

    public function setUp(): void
    {
        parent::setUp();
        $extensionManager = $this->createMock(ExtensionManager::class);
        $dispatcher = $this->createMock(Dispatcher::class);
        $this->decontaminationProcessor = new DecontaminationProcessor($extensionManager, $dispatcher);
        $this->model = new MockPostDecontaminatorModel();

        $this->attributesArray = [
            'name' => 'Rule',
            'regex' => '/strawberry/mi',
            'replacement' => 'raspberry',
            'flag' => false,
            'event' => false,
        ];

        $this->attributesArray2 = [
            'name' => 'Swear',
            'regex' => '/orange/mi',
            'replacement' => '',
            'flag' => false,
            'event' => false,
        ];
    }

    /**
     * @group unit
     */
    public function testDecontaminationProcessorIsCorrectInstanceWithMockedArgs()
    {
        $this->assertInstanceOf(DecontaminationProcessor::class, $this->decontaminationProcessor);
    }

    /**
     * @group unit
     */
    public function testProcessWithNoContentReturnsNull()
    {
        $post = $this->createMock(Post::class);
        $this->assertNull($this->decontaminationProcessor->process($this->postDecontaminatorModel, $post));
    }

    /**
     * @group unit
     */
    public function testPostWithMatchedContentHasContentReplaced()
    {
        $post = new MockPost();

        $this->assertInstanceOf(Post::class, $post);
        $post->content = ' strawberry milkshake ';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray));

        $this->decontaminationProcessor->process($this->postDecontaminatorModel->build(), $post);

        $this->assertEquals('raspberry milkshake', $post->content);
    }

    /**
     * @group unit
     */
    public function testPostWithUnmatchedContentDoesNotHaveContentReplaced()
    {
        $post = new MockPost();

        $this->assertInstanceOf(Post::class, $post);
        $post->content = 'Hello world';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray));

        $this->decontaminationProcessor->process($this->postDecontaminatorModel->build(), $post);

        $this->assertEquals('Hello world', $post->content);
    }

    /**
     * @group unit
     */
    public function testPostWithMatchedContentIsTrimmedOnlyWhenThereIsNoReplacement()
    {
        $post = new MockPost();

        $this->assertInstanceOf(Post::class, $post);
        $post->content = ' Hello orange ';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray2));

        $this->decontaminationProcessor->process($this->postDecontaminatorModel->build(), $post);

        $this->assertEquals('Hello orange', $post->content);
    }

    /**
     * @group unit
     */
    public function testProcessDiscussionWithNoTitleReturnsNull()
    {
        $discussion = $this->createMock(Discussion::class);
        $this->assertNull($this->decontaminationProcessor->processDiscussion($this->postDecontaminatorModel, $discussion));
    }

    /**
     * @group unit
     */
    public function testDiscussionWithMatchedTitleHasTitleReplaced()
    {
        $discussion = new MockDiscussion();

        $this->assertInstanceOf(Discussion::class, $discussion);
        $discussion->title = ' I like strawberry ice cream ';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray));

        $this->decontaminationProcessor->processDiscussion($this->postDecontaminatorModel->build(), $discussion);

        $this->assertEquals('I like raspberry ice cream', $discussion->title);
    }

    /**
     * @group unit
     */
    public function testDiscussionWithUnmatchedTitleDoesNotHaveTitleReplaced()
    {
        $discussion = new MockDiscussion();

        $this->assertInstanceOf(Discussion::class, $discussion);
        $discussion->title = 'Hello world';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray));

        $this->decontaminationProcessor->processDiscussion($this->postDecontaminatorModel->build(), $discussion);

        $this->assertEquals('Hello world', $discussion->title);
    }

    /**
     * @group unit
     */
    public function testDiscussionWithMatchedTitleIsTrimmedOnlyWhenThereIsNoReplacement()
    {
        $discussion = new MockDiscussion();

        $this->assertInstanceOf(Discussion::class, $discussion);
        $discussion->title = ' Hello orange ';

        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray2));

        $this->decontaminationProcessor->processDiscussion($this->postDecontaminatorModel->build(), $discussion);

        $this->assertEquals('Hello orange', $discussion->title);
    }

    /**
     * @group unit
     */
    public function testBuildDataArray()
    {
        $this->postDecontaminatorModel->shouldReceive('build')
            ->andReturn($this->getAttributes($this->attributesArray));
        $model = $this->postDecontaminatorModel->build();
        $expected = [
            "type" => "flags",
            "attributes" => ["reason" => null, "reasonDetail" => "Rule"],
            "relationships" => ["user" => ["data" => ["type" => "users", "id" => 1]], "post" => ["data" => ["type" => "posts", "id" => 1]]]
        ];

        $actual = $this->decontaminationProcessor->buildDataArray(
            $model->name,
            1,
            1
        );
        $this->assertEquals($expected, $actual);
    }

    public function getAttributes($attributesArray)
    {
        $response = new PostDecontaminatorModel();
        foreach ($attributesArray as $key => $value) {
            $response->$key = $value;
        }
        return $response;
    }

}
