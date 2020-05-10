import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';

export default class EditDecontaminatorRuleModal extends Modal {
  init() {
    super.init();

    this.rule = this.props.rule || app.store.createRecord('decontaminator');

    this.regex = m.prop(this.rule.regex() || '');
    this.name = m.prop(this.rule.name() || '');
    this.replacement = m.prop(this.rule.replacement() || '');
    this.flag = m.prop(this.rule.flag() || '');
    this.event = m.prop(this.rule.event() || 'save');
  }

  className() {
    return 'EditProfanityModal Modal--medium';
  }

  title() {
    return app.translator.trans('flarumite-decontaminator.admin.edit_rule.title');
  }

  content() {
    return (
      <div className="Modal-body">
        <div className="Form">

          <div className="Form-group">
            <label>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.name_label')}
              <input
                className="FormControl"
                placeholder=''
                value={this.name()}
                oninput={e => {
                  this.name(e.target.value);
                }}
              />
            </label>
            {app.translator.trans('flarumite-decontaminator.admin.edit_rule.name_help')}
          </div>
          <div className="Form-group">
            <label>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.regex_label')}
              <input
                className="FormControl"
                placeholder=''
                value={this.regex()}
                oninput={e => {
                  this.regex(e.target.value);
                }}
              />
            </label>
            {app.translator.trans('flarumite-decontaminator.admin.edit_rule.regex_help')}
            <br/>
            <a href="https://regex101.com" target="_blank">regex101.com</a>
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.replacement_label')}
              <input
                className="FormControl"
                placeholder=''
                value={this.replacement()}
                oninput={e => {
                  this.replacement(e.target.value);
                }}
              />
            </label>
            {app.translator.trans('flarumite-decontaminator.admin.edit_rule.replacement_help')}
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.flag_label')}</label>
            <input
              type="checkbox"
              checked={this.flag()}
              onclick={e => {
                this.flag(e.target.checked);
              }}
            />
            <p>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.flag_help')}</p>
          </div>

          <div className="Form-group">
            <label>{app.translator.trans('flarumite-decontaminator.admin.edit_rule.applywhen_label')}
              <select className="FormControl"

                oninput={m.withAttr('value', this.event)}
                value={this.event()}
              >
                <option value="save">{app.translator.trans('flarumite-decontaminator.admin.edit_rule.action.save')}</option>
                <option value="load">{app.translator.trans('flarumite-decontaminator.admin.edit_rule.action.load')}
              </option>
              </select>
            </label>
            {app.translator.trans('flarumite-decontaminator.admin.edit_rule.applywhen_help')}
          </div>

          <div className="Form-group">
            {Button.component({
              type: 'submit',
              className: 'Button Button--primary EditProfanityModal-save',
              loading: this.loading,
              children: app.translator.trans('flarumite-decontaminator.admin.edit_rule.submit_button'),
            })}
            {this.rule.exists ? (
              <button type="button" className="Button EditProfanityModal-delete"
                onclick={this.delete.bind(this)}>
                {app.translator.trans('flarumite-decontaminator.admin.edit_rule.delete_button')}
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

    this.rule.save(
      {
        name: this.name(),
        regex: this.regex(),
        event: this.event(),
        flag: this.flag(),
        replacement: this.replacement(),
        type: 'decontaminator',
      },
      { errorHandler: this.onerror.bind(this) }
    )
      .then(this.hide.bind(this))
      .catch(() => {
        this.loading = false;
        m.redraw();
      });
  }

  onhide() {
    m.route(app.route('decontaminator'));
  }

  delete() {
    if (
      confirm(
        app.translator.trans('giffgaff-decontaminator.admin.edit_rule.delete_confirmation')
      )) {
      this.rule.delete().then(() => m.redraw());
      this.hide();
    }
  }
}
