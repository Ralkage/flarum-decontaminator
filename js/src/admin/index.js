import { extend } from 'flarum/extend';
import app from 'flarum/app';
import DecontaminatorRow from '../common/models/Decontaminator';
import addDecontaminatorPane from './addDecontaminatorPane';
import PermissionGrid from 'flarum/components/PermissionGrid';

app.initializers.add('flarumite/decontaminator', (app) => {
    app.store.models.decontaminator = DecontaminatorRow;

    extend(PermissionGrid.prototype, 'moderateItems', (items) => {
        items.add('bypassDecontaminator', {
            icon: 'far fa-eye-slash',
            label: app.translator.trans('flarumite-decontaminator.admin.permissions.bypass-filter'),
            permission: 'user.bypassDecontaminator',
        });
    });

    addDecontaminatorPane();
});
