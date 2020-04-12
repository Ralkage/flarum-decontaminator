import ProfanityRow from '../common/models/Profanity';
import addPagesPane from './addPagesPane';

app.initializers.add('imorland/profanity', app => {
    app.store.models.profanities = ProfanityRow;

    addPagesPane();
});
