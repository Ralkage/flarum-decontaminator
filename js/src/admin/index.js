import ProfanityRow from '../common/models/Profanity';
import addPagesPane from './addPagesPane';

app.initializers.add('flarumite/profanity', app => {
    app.store.models.profanities = ProfanityRow;

    addPagesPane();
});
