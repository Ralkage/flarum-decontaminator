
<?php

use Flarum\Database\Migration;
use Flarum\Group\Group;

return Migration::addPermissions([
    'user.bypassDecontaminator' => Group::MODERATOR_ID,
]);
