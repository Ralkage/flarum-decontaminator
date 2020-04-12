import Page from 'flarum/components/Page';
import ProfanitiesList from './ProfanitiesList';
import ProfanitiesHeader from "./ProfanitiesHeader";

export default class ProfanitiesPage extends Page {
  view() {
    return (
      <div className="ProfanitiesPage">
        <div className="ProfanitiesPage-header">{ProfanitiesHeader.component()}</div>
        <div className="ProfanitiesPage-list">
          <div className="container">{ProfanitiesList.component()}</div>
        </div>
      </div>
    );
  }
}
