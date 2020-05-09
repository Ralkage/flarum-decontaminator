import Button from 'flarum/components/Button';
import Checkbox from 'flarum/components/Checkbox';
import Component from 'flarum/Component';
import EditProfanityModal from './EditProfanityModal';

export default class ProfanitiesListItem extends Component {

    view() {
        const profanity = this.props.profanity;
        return (

            <tr key={profanity.data.id}>
                <th>{profanity.data.attributes.name}</th>
                <th>{profanity.data.attributes.regex}</th>
                <th>{profanity.data.attributes.replacement}</th>
                <th>{Checkbox.component({
                    state: profanity.data.attributes.flag,
                    onchange: this.updateFlag.bind(this)
                })}</th>
                <td className="Profanities-actions">

                    <div className="ButtonGroup">
                        {Button.component({
                            className: 'Button Button--Profanities-edit',
                            icon: 'fas fa-pencil-alt',
                            onclick: () => app.modal.show(new EditProfanityModal({ profanity })),
                        })}

                        {Button.component({
                            className: 'Button Button--danger Button--Profanities-delete',
                            icon: 'fas fa-times',
                            onclick: this.delete.bind(this),
                        })}
                    </div>
                </td>
            </tr>

        );
    }

    updateFlag() {
        this.props.profanity.save({
            name: this.props.profanity.data.attributes.name,
            flag: (this.props.profanity.data.attributes.flag ? 0 : 1),
            regex: this.props.profanity.data.attributes.regex,
            event: this.props.profanity.data.attributes.event,
            replacement: this.props.profanity.data.attributes.replacement,
            type: 'profanity'
        }).then(() => m.redraw());
    }


    delete() {
        if (confirm(app.translator.trans('flarumite-post-decontaminator.admin.delete_profanity_confirmation'))) {
            this.props.profanity.delete().then(() => m.redraw());
            m.route(app.route('profanities'));
        }
    }
}
