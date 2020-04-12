import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';

/**
 * The `EditPageModal` component shows a modal dialog which allows the user
 * to create or edit a profanitiesObject.
 */
export default class EditPageModal extends Modal {
  init() {
    super.init();

    this.profanity = this.props.profanity || app.store.createRecord('profanities');

    this.regex = m.prop(this.profanity.regex() || '');
    this.name = m.prop(this.profanity.name() || '');
    this.replacement = m.prop(this.profanity.replacement() || '');
    this.flag = m.prop(this.profanity.flag() || '');
    this.event = m.prop(this.profanity.event() || '');
  }

  className() {
    return 'EditProfanityModal Modal--medium';
  }

  title() {
    return app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.title');
  }

  content() {
    return (
      <div className="Modal-body">
        <div className="Form">

          <div className="Form-group">
            <label>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.name_label')}</label>
            <input
              className="FormControl"
              placeholder=''
              value={this.name()}
              oninput={e => {
                this.name(e.target.value);
              }}
            />
          </div>
          <div className="Form-group">
            <label>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.regex_label')}</label>
            <input
              className="FormControl"
              placeholder=''
              value={this.regex()}
              oninput={e => {
                this.regex(e.target.value);
              }}
            />
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.replacement_label')}</label>
            <input
              className="FormControl"
              placeholder=''
              value={this.replacement()}
              oninput={e => {
                this.replacement(e.target.value);
              }}
            />
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.flag_label')}</label>
            <input
              className="FormControl"
              value={this.flag()}
              oninput={e => {
                this.flag(e.target.value);
              }}
            />
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.applywhen_label')}</label>
            <select className="FormControl"

                    oninput={m.withAttr('value', this.event)}
                    value={this.event()}
            >
              <option value="save">Saving a Post</option>
              <option value="load">Loading a Post (this can have an adverse performance impact)
              </option>
            </select>
          </div>

          <div className="Form-group">
            {Button.component({
                                type: 'submit',
                                className: 'Button Button--primary EditProfanityModal-save',
                                loading: this.loading,
                                children: app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.submit_button'),
                              })}
            {this.profanity.exists ? (
              <button type="button" className="Button EditProfanityModal-delete"
                      onclick={this.delete.bind(this)}>
                      {app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.delete_button')}
              </button>
            ) : (
               ''
             )}
          </div>
        </div>
      </div>
    );
  }

  onsubmit(e) {
    e.preventDefault();

    this.loading = true;

    this.profanity.save(
      {
        name: this.name(),
        regex: this.regex(),
        event: this.event(),
        flag: this.flag(),
        replacement: this.replacement(),
        type: 'profanity',
      },
      {errorHandler: this.onerror.bind(this)}
    )
      .then(this.hide.bind(this))
      .catch(() => {
        this.loading = false;
        m.redraw();
      });
  }

  onhide() {
    m.route(app.route('profanities'));
  }

  delete() {
    if (
      confirm(
        app.translator.trans('giffgaff-post-decontaminator.admin.edit_profanity.delete_confirmation')
      )) {
      this.profanity.delete().then(() => m.redraw());
      this.hide();
    }
  }
}
