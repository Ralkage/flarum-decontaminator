import { extend } from 'flarum/extend';
import app from 'flarum/app';
import ProfanityRow from '../common/models/Profanity';
import addPagesPane from './addPagesPane';
import PermissionGrid from 'flarum/components/PermissionGrid';

app.initializers.add('flarumite/profanity', app => {
    app.store.models.profanities = ProfanityRow;

    extend(PermissionGrid.prototype, 'moderateItems', (items) => {
        items.add('bypassDecontaminator', {
            icon: 'far fa-eye-slash',
            label: app.translator.trans('flarumite-post-decontaminator.admin.permissions.bypass-filter'),
            permission: 'user.bypassDeccontaminator',
        });
    });

    addPagesPane();
});
