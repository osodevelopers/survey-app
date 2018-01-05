
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
import takeSurvey from './components/survey/TakeSurvey.vue';
import resultSurvey from './components/survey/ResultSurvey.vue';
import questionsSurvey from './components/question/QuestionsSurvey.vue';
import PageNotFound from './components/PageNotFound.vue';

const routes = [
  { path: '/login', component: Login },
  // Not Found Route
  { path: "*", component: PageNotFound },
  { path: '/dashboard', component: Dashboard ,
	children: [
        // List of Surveys
        {
          path: 'survey',
          component: Survey,
          name: 'survey',
          meta: {description: 'List of our Serveys', requiresAuth: true}
        },
        // Edit survey
        {
          path: 'edit-survey/:id',
          component: EditSurvey,
          name: 'edit-survey',
  	      meta: {description: 'List of our Serveys', requiresAuth: true}
        },
        // Create new Survey
        {
          path: 'create-survey',
          component: createSurvey,
          name: 'create-survey',
  	      meta: {description: 'Create Survey', requiresAuth: true}
        },
        // Create New Question for Survey
        { 
          path: 'create-question/:survey',
          component: createQuestion,
          name: 'create-question',
          meta: {description: 'Create Question', requiresAuth: true}
        },
        // Take Survey
        { 
          path: 'survey/take/:survey',
          component: takeSurvey,
          name: 'take-survey',
          meta: {description: 'Take Survey', requiresAuth: true}
        },
        // Result of Survey
        { 
          path: 'survey/result/:survey',
          component: resultSurvey,
          name: 'result-survey',
          meta: {description: 'Survey Result', requiresAuth: true}
        },
        // List of Questions in The survey
        { 
          path: 'survey/questions/:survey',
          component: questionsSurvey,
          name: 'questions-survey',
          meta: {description: 'Survey Questions', requiresAuth: true}
        }
      ] 
  },
  // { path: '/survey', component: Survey },
  // { path: '/create-survey', component: createSurvey },
];
export default routes