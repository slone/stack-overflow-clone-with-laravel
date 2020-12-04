<template>
	<div class="card-body">
		<div v-if="questions.length">
			<div class="count">{{  count }} found</div>
			<question-excerpt @deleted="remove(index)" v-for="(question, index) in questions" :question="question" :key="question.id"></question-excerpt>
		</div>

		<div v-else class="alert alert-warning">Sorry, there are no questions available </div>
		<div v-if="questions.length && meta.last_page > 1" class="card-footer">
			<pagination :meta="meta" :links="links"></pagination>
		</div>
	</div>
	
</template>
<script>
import QuestionExcerpt from '../components/QuestionExcerpt';
import Pagination from '../components/Pagination';

export default {
	components: { QuestionExcerpt, Pagination },
	data() {
		return {
			questions: [],
			meta: {},
			links: {},
			count: 0,
		}
	},
	watch: {
		'$route' : 'fetchQuestions'
	},
	mounted() {
		this.fetchQuestions();
	},
	methods: {
		remove(index) {
			this.questions.splice(index, 1);
			this.count--;
		},
		fetchQuestions() {
			axios
			.get('/questions', { params: this.$route.query })
			.then( ( {data} ) => {
				this.questions = data.data;
				this.meta = data.meta;
				this.links = data.links;
				this.count = data.meta.total;
			})
			.catch(({ response }) => {
				this.$toast.error(response.data.message, 'Error',  { timeout: 4000 });
			});
		}
	}
}
</script>