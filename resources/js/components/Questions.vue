<template>
	<div class="card-body">
		<transition name="fade" mode="out-in">
		<loading-spinner v-if="$root.isLoading"></loading-spinner>
		<div v-else-if="questions.length" class="list">
			<div>
				<div class="count">{{  count }} found</div>
				<question-excerpt v-for="question in questions" :question="question" :key="question.id"></question-excerpt>
			</div>

			<div v-if="questions.length && meta.last_page > 1" class="card-footer">
				<pagination :meta="meta" :links="links"></pagination>
			</div>
		</div>
		<div v-else class="alert alert-warning">Sorry, there are no questions available </div>

		</transition>
	</div>
	
</template>
<script>
import QuestionExcerpt from '../components/QuestionExcerpt';
import Pagination from '../components/Pagination';
import EventBus from '../event-bus';

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
		EventBus.$on('deleted', (id) =>  {
			console.log("deleted ", id);
			let index = this.questions.findIndex(question => id === question.id);
			this.remove(index);
		});
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