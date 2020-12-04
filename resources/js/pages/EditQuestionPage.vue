<template>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h2>Edit question</h2>
						<div class="ml-auto">
							<router-link :to="{ name: 'questions' }" class="btn btn-outline-secondary" exact>Back to all questions</router-link>
						</div>
					</div>
				</div>

				<div class="card-body">
					<question-form @question-form-submitted="update" :is-edit="true"></question-form>
				</div>
			</div>
		</div>
	</div>
</div>	
</template>
<script>
import EventBus from '../event-bus';
import QuestionForm from '../components/QuestionForm';
export default {
	components: { QuestionForm },
	methods: {
		update(data) {
			axios
				.put('/questions/' + this.$route.params.id, data)
				.then(({data}) => {
					this.$router.push({name: 'questions'});
					this.$toast.success(data.message, 'Success');
				})
				.catch( ({response}) => {
					EventBus.$emit('question-form-error', response.data.errors);
					this.$toast.error(response.data.message, 'Error',  { timeout: 5000 });
				});
		}
	}
}
</script>