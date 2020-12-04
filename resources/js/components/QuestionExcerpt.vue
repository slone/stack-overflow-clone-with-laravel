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
			<h3 class="mt-0"><a href="#">{{ question.title }}</a></h3>
			<div class="ml-auto">
				<a v-if="authorize('modify', question)" href="#" class="btn btn-sm btn-outline-info">Edit</a>

				<form v-if="authorize('deleteQuestion', question)" method="post" action="" class="form-delete">
					<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you wish to delete this question?')">Delete	</button>
				</form>

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
export default {
	props: ['question'],
	methods: {
		str_plural(str, count) {
			return str + (count > 1 ? 's' : '');
		}
	},
	computed: {
		questionStatusClasses() {
			console.log(this.question.status);
			return [
				'status',
				this.question.status
			]	
		}
	}
}
</script>