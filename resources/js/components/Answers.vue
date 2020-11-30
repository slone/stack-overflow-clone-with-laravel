<template>
<div v-if="count" v-cloak class="row mt-4 justify-content-center answers-wrapper">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="card-title">
					<h2> {{ title }} </h2>
				</div>
				<hr>
				<answer @answer-deleted="removeAnswer(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>

				<div class="text-center mt-3" v-if="nextUrl">
					<button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
				</div>
	
			</div>
		</div>
	</div>
</div>
	
</template>


<script>
import Answer from './Answer';

export default {

	props: ['question'],
	components: {Answer},
	data() {
		return {
			questionId: this.question.id,
			count: this.question.answers_count,
			nextUrl: null,
			answers: []
		}
	},
	created() {
		this.fetch(`/questions/${this.questionId}/answers`);
	},
	computed: {
		title() {
			return this.count+ " " + (this.count > 1 ? 'answers' : 'answer');
		},
	},
	methods: {
		fetch(endpoint) {
			axios.get(endpoint)
			.then( ({data}) => {
				this.answers.push(...data.data);
				this.nextUrl = data.next_page_url;
			})
			.catch( err => {
				console.log(err);
			})
		},
		removeAnswer(index) {
			this.answers.splice(index, 1);
			this.count--;
		}
	}

}
</script>