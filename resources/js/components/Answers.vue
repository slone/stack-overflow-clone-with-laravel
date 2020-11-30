<template>
<div v-if="count" v-cloak class="row mt-4 justify-content-center answers-wrapper">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="card-title">
					<h2> {{ title }} </h2>
				</div>
				<hr>
				<answer v-for="answer in answers" :answer="answer" :key="answer.id"></answer>
			</div>
		</div>
	</div>
</div>
	
</template>


<script>
import Answer from './Answer';

export default {

	props: ['answers', 'count'],
	components: {Answer},
	computed: {
		title() {
			return this.count+ " " + (this.count > 1 ? 'answers' : 'answer');
		}
	}

}
</script>