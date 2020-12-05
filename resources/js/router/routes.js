import QuestionsPage 		from '../pages/QuestionsPage';
import QuestionPage 		from '../pages/QuestionPage';
import CreateQuestionPage 	from '../pages/CreateQuestionPage';
import EditQuestionPage 	from '../pages/EditQuestionPage';
import MyPostsPage 			from '../pages/MyPostsPage';
import NotFoundPage 		from '../pages/NotFoundPage';

const routes = [
	{
		path: '/',
		component: QuestionsPage,
		name: 'home',
	},
	{
		path: '/questions',
		component: QuestionsPage,
		name: 'questions',
	},
	{
		path: '/questions/create',
		component: CreateQuestionPage,
		name: 'questions.create',
		meta: {
			requireAuth: true,
		}
	},
	{
		path: '/questions/:id/edit',
		component: EditQuestionPage,
		name: 'questions.update',
		meta: {
			requireAuth: true,
		}
	},
	{
		path: '/my-posts',
		component: MyPostsPage,
		name: 'my-posts',
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/questions/:slug',
		component: QuestionPage,
		name: 'questions.show',
		props: true,
	},
	{
		path: '*',
		component: NotFoundPage
	}
]

export default routes;