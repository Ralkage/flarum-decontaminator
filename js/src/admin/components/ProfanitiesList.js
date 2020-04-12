import Component from 'flarum/Component';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import Placeholder from 'flarum/components/Placeholder';

import ProfanitiesListItem from './ProfanitiesListItem';


export default class ProfanitiesList extends Component {
    init() {

        this.loading = true;
        this.profanities = [];
        this.page = 0;
        this.refresh();
    }

    view() {
        if (this.loading) {
            return <div className="ProfanitiesList-loading">{LoadingIndicator.component()}</div>;
        }

        if (this.profanities.length === 0) {
            const text = app.translator.trans('imorland-post-decontaminator.admin.profanities_list.empty_text');
            return Placeholder.component({ text });
        }


        return (
            <div className="ProfanitiesList">
                <table className="ProfanitiesList-results">
                    <thead>
                        <tr>
                            <th>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.name_label')}</th>
                            <th>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.regex_label')}</th>
                            <th>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.replacement_label')}</th>
                            <th>{app.translator.trans('imorland-post-decontaminator.admin.edit_profanity.flag_label')}</th>
                            {/*leave blank for the action buttons*/}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            this.profanities.map(profanity => {
                            return ProfanitiesListItem.component({ profanity });
                        })}
                    </tbody>
                </table>
            </div>
        );
    }

    refresh(clear = true) {
        if (clear) {
            this.loading = true;
            this.profanities = [];
        }

        return this.loadResults().then(this.parseResults.bind(this));
    }


    loadResults() {
        return app.store.find('profanities');
    }


    parseResults(results) {
        [].push.apply(this.profanities, results);

        this.loading = false;

        m.lazyRedraw();
        return results;
    }

    loadNext() {
    }

    loadPrev() {
    }
}
