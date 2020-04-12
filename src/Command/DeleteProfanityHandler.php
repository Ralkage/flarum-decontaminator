<?php

namespace imorland\PostDecontaminator\Command;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\AssertPermissionTrait;
use imorland\PostDecontaminator\PostDecontaminatorRepository;

class DeleteProfanityHandler
{
    use AssertPermissionTrait;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var ProfanityRepository
     */
    protected $repository;

    /**
     * @param ProfanityRepository $profanityRepository
     */
    public function __construct(PostDecontaminatorRepository $repository, SettingsRepositoryInterface $settings)
    {
        $this->repository = $repository;
        $this->settings = $settings;
    }

    /**
     * @param DeleteProfanity $command
     *
     * @return \giffgaff\PostDecontaminator\PostDecontaminatorModel
     */
    public function handle(DeleteProfanity $command)
    {
        $actor = $command->actor;

        $page = $this->repository->findOrFail($command->pageId, $actor);

        $this->assertAdmin($actor);
        

        $page->delete();

        return $page;
    }
}
