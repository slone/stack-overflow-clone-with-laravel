<template>
<div>
	<div v-if="count" v-cloak class="row mt-4 justify-content-center answers-wrapper">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="card-title">
						<h2> {{ title }} </h2>
					</div>
					<hr>
					<answer @answer-deleted="removeAnswer(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>

					<div class="text-center mt-3" v-if="theNextUrl">
						<button @click.prevent="fetch(theNextUrl)" class="btn btn-outline-secondary">Load more answers</button>
					</div>
		
				</div>
			</div>
		</div>
	</div>
	<new-answer @new-answer-added="add" :question-id="question.id"></new-answer>
</div>
	
</template>


<script>
import Answer from './Answer';
import NewAnswer from './NewAnswer';
import EventBus from '../event-bus';

export default {

	props: ['question'],
	components: {Answer, NewAnswer},
	data() {
		return {
			questionId: this.question.id,
			count: this.question.answers_count,
			nextUrl: null,
			answers: [],
			excludeAnswers: [],
		}
	},
	created() {
		this.fetch(`/questions/${this.questionId}/answers`);
	},
	computed: {
		title() {
			return this.count+ " " + (this.count > 1 ? 'answers' : 'answer');
		},
		theNextUrl() {
			if (this.nextUrl && this.excludeAnswers.length) {
				return this.nextUrl + this.excludeAnswers.map(a => '&excludes[]=' + a.id).join('');
			}
			return this.nextUrl;
		},
	},
	methods: {
		add(answer) {
			this.answers.push(answer);
			this.excludeAnswers.push(answer);
			console.log(this.excludeAnswers);
			this.count++;
			EventBus.$emit('answers-count-changed', this.count);
		},
		fetch(endpoint) {
			axios.get(endpoint)
			.then( ({data}) => {
				this.answers.push(...data.data);
				this.nextUrl = data.links.next;
			})
			.catch( err => {
				console.log(err);
			})
		},
		removeAnswer(index) {
			this.answers.splice(index, 1);
			this.count--;
			EventBus.$emit('answers-count-changed', this.count);
		}
	}

}
</script>