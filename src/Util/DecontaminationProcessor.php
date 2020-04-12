<?php

namespace imorland\PostDecontaminator\Util;

use Flarum\Post\Post;
use Flarum\Discussion\Discussion;
use imorland\PostDecontaminator\PostDecontaminatorModel;
use Symfony\Component\Translation\TranslatorInterface;
use Flarum\Flags\Command\CreateFlag;
use Illuminate\Contracts\Bus\Dispatcher;
use Flarum\User\User;

class DecontaminationProcessor
{
    private $translator;
    private $matchedWord = null;

    /**
     * @var Dispatcher
     */
    protected $bus;

    public function __construct(TranslatorInterface $translator, Dispatcher $bus)
    {
        $this->translator = $translator;
        $this->bus = $bus;
    }

    public function process(PostDecontaminatorModel $model, Post $post): void
    {
        if (!is_string($post->content)) {
            return;
        }

        if (preg_match($model->regex, trim($post->content), $this->matchedWord)) {
            $trimmedContent = trim($post->content);
            $post->content = $this->processRegEx($model, $trimmedContent);
            if ($model->flag) {
                $post->afterSave(function ($post) use ($model) {
                    $this->raiseFlag($post, $model);
                });
            }
        }
    }

    public function processDiscussion(PostDecontaminatorModel $model, Discussion $discussion, $renamed = false): void
    {
        if (!is_string($discussion->title)) {
            return;
        }

        if (preg_match($model->regex, trim($discussion->title), $this->matchedWord)) {
            $trimmedTitle = trim($discussion->title);
            $discussion->title = $this->processRegEx($model, $trimmedTitle);

            // More work needed here. Need to get the first post saved in the discussion, and pass the ID to raiseFlag()
            // For now, we cleanse the title, but no flag is raised.

            if ($model->flag) {
                if ($renamed) {
                    $post = Post::where('discussion_id', $discussion->id)->where('number', 1)->first();
                    if ($post !== null) {
                        $this->raiseFlag($post, $model);
                    }

                } else {
                    $discussion->afterSave(function ($discussion) use ($model) {
                        $post = Post::where('discussion_id', $discussion->id)->where('number', 1)->first();
                        if ($post !== null) {
                            $this->raiseFlag($post, $model);
                        }
                    });
                }
            }
        }
    }

    private function processRegEx(PostDecontaminatorModel $model, string $content): ?string
    {
        if (empty($model->replacement)) {
            return $content;
        }

        return preg_replace($model->regex, $model->replacement, $content);
    }

    public function raiseFlag(Post $post, PostDecontaminatorModel $model, $matches = ''): void
    {
        if($post->discussion->is_private){
            $reportingUser = User::where('id', $post->user_id)->first();
        } else {
            $reportingUser = User::where('id', '1')->first();
        }

        if ($matches !== '') {
            $matches = ' [' . $matches . ']';
        }
        
        $data = [
            "type" => "flags",
            "attributes" => [
                "reason" => null,
                "reasonDetail" => $model->name . $matches
            ],
            "relationships" => [
                "user" => [
                    "data" => [
                        "type" => "users",
                        "id" => $reportingUser->id
                    ]
                ],
                "post" => [
                    "data" => [
                        "type" => "posts",
                        "id" => $post->id
                    ]
                ]
            ]
        ];

        $this->bus->dispatch(new CreateFlag($reportingUser, $data));
    }
}
