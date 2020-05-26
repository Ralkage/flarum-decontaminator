import { extend } from 'flarum/extend';
import AdminNav from 'flarum/components/AdminNav';
import AdminLinkButton from 'flarum/components/AdminLinkButton';
import DecontaminatorPage from './components/DecontaminatorPage';

export default function () {
    app.routes.decontaminator = { path: 'decontaminator', component: DecontaminatorPage.component() };

    app.extensionSettings['decontaminator-manager'] = () => m.route(app.route('decontaminator'));

    extend(AdminNav.prototype, 'items', (items) => {
        items.add(
            'decontaminator-manager',
            AdminLinkButton.component({
                href: app.route('decontaminator'),
                icon: 'fas fa-file-alt',
                children: 'Decontaminator',
                description: 'Powerful content replacement tool',
            })
        );
    });
}
