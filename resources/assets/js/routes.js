
// const Dashboard = require('./components/Dashboard.vue');
// const createSurvey = require('./components/survey/CreateSurvey.vue');
// const Survey = require('./components/survey/Survey.vue');
// const createQuestion = require('./components/question/CreateQuestion.vue');
// const Login = require('./components/login/Login.vue');

import Dashboard from './components/Dashboard.vue';
import createSurvey from './components/survey/CreateSurvey.vue';
import Survey from './components/survey/Survey.vue';
import EditSurvey from './components/survey/EditSurvey.vue';
import createQuestion from './components/question/CreateQuestion.vue';
import Login from './components/login/Login.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/dashboard', component: Dashboard ,
	children: [
        {
          path: 'survey',
          component: Survey,
          name: 'survey',
          meta: {description: 'List of our Serveys', requiresAuth: true}
        },
        {
          path: 'edit-survey/:id',
          component: EditSurvey,
          name: 'edit-survey',
  	      meta: {description: 'List of our Serveys', requiresAuth: true}
        },
        {
          path: 'create-survey',
          component: createSurvey,
          name: 'create-survey',
  	      meta: {description: 'Create Survey', requiresAuth: true}
        },
        { 
          path: 'create-question/:survey',
          component: createQuestion,
          name: 'create-question',
          meta: {description: 'Create Question', requiresAuth: true}
        }
      ] 
  },
  // { path: '/survey', component: Survey },
  // { path: '/create-survey', component: createSurvey },
];
export default routes