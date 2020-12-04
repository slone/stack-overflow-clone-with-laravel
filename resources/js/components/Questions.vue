<template>
	<div class="card-body">
							
		<div v-if="questions.length">
			<question-excerpt v-for="question in questions" :question="question" :key="question.id"></question-excerpt>
		</div>

		<div v-else class="alert alert-warning">Sorry, there are no questions available </div>
		<div class="card-footer">
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
			links: {}
		}
	},
	watch: {
		'$route' : 'fetchQuestions'
	},
	mounted() {
		this.fetchQuestions();
	},
	methods: {
		fetchQuestions() {
			axios
			.get('/questions', { params: this.$route.query })
			.then( ( {data} ) => {
				this.questions = data.data;
				this.meta = data.meta;
				this.links = data.links;
			})
			.catch(({ response }) => {
				this.$toast.error(response.data.message, 'Error',  { timeout: 4000 });
			});
		}
	}
}
</script>