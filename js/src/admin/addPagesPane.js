import { extend } from 'flarum/extend';
import AdminNav from 'flarum/components/AdminNav';
import AdminLinkButton from 'flarum/components/AdminLinkButton';

import ProfanitiesPage from './components/ProfanitiesPage';

export default function() {
    app.routes.profanities = { path: 'profanities', component: ProfanitiesPage.component() };

    app.extensionSettings['profanity-manager'] = () => m.route(app.route('profanities'));

    extend(AdminNav.prototype, 'items', items => {
        items.add(
            'profanity-manager',
            AdminLinkButton.component({
                href: app.route('profanities'),
                icon: 'fas fa-file-alt',
                children:'Post Decontaminator',
                description: 'Tool to replace profanities',
            })
        );
    });
}
