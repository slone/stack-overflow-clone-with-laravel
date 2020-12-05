<template>
<div class="media post question-wrapper">
	<div class="d-flex flex-column counters">
		<div class="vote">
			<strong>{{ question.votes_count }}</strong> <span class="label">{{ str_plural('vote', question.votes_count) }}</span>
		</div>
		<div :class="questionStatusClasses">
			<strong>{{ question.answers_count }}</strong> <span class="label">{{ str_plural('answer', question.answers_count) }}</span>
		</div>
		<div class="view">
			{{ question.views +' '+ str_plural('view', question.views) }}
		</div>
	</div>
	<div class="media-body">
		<div class="d-flex align-items-center">
			<h3 class="mt-0"><router-link :to="{ name: 'questions.show', params: { slug: question.slug }}">{{ question.title }}</router-link></h3>
			<div class="ml-auto">
				<router-link v-if="authorize('modify', question)" :to="{ name: 'questions.update', params: { id: question.id } }" class="btn btn-sm btn-outline-info" exact>Edit</router-link>

				<button v-if="authorize('deleteQuestion', question)" type="submit" class="btn btn-sm btn-outline-danger" @click="destroy">Delete	</button>

			</div>
		</div>
		<p class="lead">
			Asked by <a href="#">{{ question.user.name }}</a>
			<small class="text-muted">{{ question.created_date }}</small>
		</p>
		<div class="excerpt"> {{ question.excerpt }} </div>
	</div>
</div>	
</template>
<script>
import destroy from '../mixins/destroy';
export default {
	props: ['question'],
	mixins: [destroy],
	methods: {
		str_plural(str, count) {
			return str + (count > 1 ? 's' : '');
		},
		delete() {
			axios.delete("/questions/" + this.question.id)
			.then( ({data}) => {
				this.$toast.success(data.message, "Success", { timeout: 5000 });
				this.$emit('deleted');
			})
			.catch( ({response}) => {
				this.$toast.error(response.data.message, 'Error');
			});
		},
	},
	computed: {
		questionStatusClasses() {
			return [ 'status', this.question.status	];	
		}
	}
}
</script>