import Component from "flarum/Component";
import EditDecontaminatorRuleModal from "./EditDecontaminatorRuleModal";
import Button from "flarum/components/Button";

export default class DecontaminatorHeader extends Component {
  view() {
    return (
      <div className="container">
        <p>
          {app.translator.trans(
            "flarumite-decontaminator.admin.decontaminator.about_text"
          )}
        </p>

        {Button.component({
          className: "Button Button--primary",
          icon: "fas fa-plus",
          children: app.translator.trans(
            "flarumite-decontaminator.admin.decontaminator.create_button"
          ),
          onclick: () => app.modal.show(new EditDecontaminatorRuleModal()),
        })}
      </div>
    );
  }
}
