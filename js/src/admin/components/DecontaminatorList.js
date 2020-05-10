import Component from "flarum/Component";
import LoadingIndicator from "flarum/components/LoadingIndicator";
import Placeholder from "flarum/components/Placeholder";
import DecontaminatorListItem from "./DecontaminatorListItem";

export default class DecontaminatorList extends Component {
  init() {
    this.loading = true;
    this.decontaminator = [];
    this.page = 0;
    this.refresh();
  }

  view() {
    if (this.loading) {
      return (
        <div className="DecontaminatorList-loading">
          {LoadingIndicator.component()}
        </div>
      );
    }

    if (this.decontaminator.length === 0) {
      const text = app.translator.trans(
        "flarumite-decontaminator.admin.list.empty_text"
      );
      return Placeholder.component({ text });
    }

    return (
      <div className="DecontaminatorList">
        <table className="DecontaminatorList-results">
          <thead>
            <tr>
              <th>
                {app.translator.trans(
                  "flarumite-decontaminator.admin.edit_rule.name_label"
                )}
              </th>
              <th>
                {app.translator.trans(
                  "flarumite-decontaminator.admin.edit_rule.regex_label"
                )}
              </th>
              <th>
                {app.translator.trans(
                  "flarumite-decontaminator.admin.edit_rule.replacement_label"
                )}
              </th>
              <th>
                {app.translator.trans(
                  "flarumite-decontaminator.admin.edit_rule.flag_label"
                )}
              </th>
              {/*leave blank for the action buttons*/}
              <th></th>
            </tr>
          </thead>
          <tbody>
            {this.decontaminator.map((rule) => {
              return DecontaminatorListItem.component({ rule });
            })}
          </tbody>
        </table>
      </div>
    );
  }

  refresh(clear = true) {
    if (clear) {
      this.loading = true;
      this.decontaminator = [];
    }

    return this.loadResults().then(this.parseResults.bind(this));
  }

  loadResults() {
    return app.store.find("decontaminator");
  }

  parseResults(results) {
    [].push.apply(this.decontaminator, results);

    this.loading = false;

    m.lazyRedraw();
    return results;
  }

  loadNext() {}

  loadPrev() {}
}
