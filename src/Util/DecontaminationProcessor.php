<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator\Util;

use Flarum\Discussion\Discussion;
use Flarum\Extension\ExtensionManager;
use Flarum\Flags\Command\CreateFlag;
use Flarum\Post\Post;
use Flarum\User\User;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Illuminate\Contracts\Bus\Dispatcher;

class DecontaminationProcessor
{
    private $matchedWord = null;

    /**
     * @var Dispatcher
     */
    protected $bus;

    protected $flagsEnabled = false;

    public function __construct(ExtensionManager $extension, Dispatcher $bus)
    {
        $this->bus = $bus;

        if ($extension->isEnabled('flarum-flags') && class_exists(CreateFlag::class)) {
            $this->flagsEnabled = true;
        }
    }

    public function process(PostDecontaminatorModel $model, Post $post): void
    {
        if (!is_string($post->content)) {
            return;
        }

        if (preg_match($model->regex, trim($post->content), $this->matchedWord)) {
            $trimmedContent = trim($post->content);
            $post->content = $this->processRegEx($model, $trimmedContent);
            if ($this->flagsEnabled && $model->flag) {
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

            if ($this->flagsEnabled && $model->flag) {
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
        $actor = User::find($post->user_id);

        if ($actor->cannot('flag', $post)) {
            $actor = User::find(1);
        }

        if ($matches !== '') {
            $matches = ' ['.$matches.']';
        }

        $data = [
            'type'       => 'flags',
            'attributes' => [
                'reason'       => null,
                'reasonDetail' => $model->name.$matches,
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'users',
                        'id'   => $actor->id,
                    ],
                ],
                'post' => [
                    'data' => [
                        'type' => 'posts',
                        'id'   => $post->id,
                    ],
                ],
            ],
        ];

        $this->bus->dispatch(new CreateFlag($actor, $data));
    }
}
