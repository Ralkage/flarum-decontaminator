import Page from 'flarum/components/Page';
import DecontaminatorList from './DecontaminatorList';
import DecontaminatorHeader from './DecontaminatorHeader';

export default class DecontaminatorPage extends Page {
    view() {
        return (
            <div className="DecontaminatorPage">
                <div className="DecontaminatorPage-header">{DecontaminatorHeader.component()}</div>
                <div className="DecontaminatorPage-list">
                    <div className="container">{DecontaminatorList.component()}</div>
                </div>
            </div>
        );
    }
}
