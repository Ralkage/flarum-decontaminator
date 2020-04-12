import Component from 'flarum/Component';
import EditProfanityModal from "./EditProfanityModal";
import Button from 'flarum/components/Button';

export default class ProfanitiesHeader extends Component {
  view() {
    return (

        <div className="container">
          <p>{app.translator.trans('imorland-post-decontaminator.admin.profanities.about_text')}</p>

          {Button.component({
                              className: 'Button Button--primary',
                              icon: 'fas fa-plus',
                              children: app.translator.trans('imorland-post-decontaminator.admin.profanities.create_button'),
                              onclick: () => app.modal.show(new EditProfanityModal()),
                            })}
        </div>
    );
  }
}
