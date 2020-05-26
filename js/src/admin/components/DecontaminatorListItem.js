import Button from 'flarum/components/Button';
import Checkbox from 'flarum/components/Checkbox';
import Component from 'flarum/Component';
import EditDecontaminatorRuleModal from './EditDecontaminatorRuleModal';

export default class DecontaminatorListItem extends Component {
    view() {
        const rule = this.props.rule;
        return (
            <tr key={rule.data.id}>
                <th>{rule.data.attributes.name}</th>
                <th>{rule.data.attributes.regex}</th>
                <th>{rule.data.attributes.replacement}</th>
                <th>
                    {Checkbox.component({
                        state: rule.data.attributes.flag,
                        onchange: this.updateFlag.bind(this),
                    })}
                </th>
                <td className="Decontaminator-actions">
                    <div className="ButtonGroup">
                        {Button.component({
                            className: 'Button Button--Decontaminator-edit',
                            icon: 'fas fa-pencil-alt',
                            onclick: () => app.modal.show(new EditDecontaminatorRuleModal({ rule })),
                        })}

                        {Button.component({
                            className: 'Button Button--danger Button--Decontaminator-delete',
                            icon: 'fas fa-times',
                            onclick: this.delete.bind(this),
                        })}
                    </div>
                </td>
            </tr>
        );
    }

    updateFlag() {
        this.props.rule
            .save({
                name: this.props.rule.data.attributes.name,
                flag: this.props.rule.data.attributes.flag ? 0 : 1,
                regex: this.props.rule.data.attributes.regex,
                event: this.props.rule.data.attributes.event,
                replacement: this.props.rule.data.attributes.replacement,
                type: 'decontaminator',
            })
            .then(() => m.redraw());
    }

    delete() {
        if (confirm(app.translator.trans('flarumite-decontaminator.admin.delete_rule_confirmation'))) {
            this.props.rule.delete().then(() => m.redraw());
            m.route(app.route('decontaminator'));
        }
    }
}
