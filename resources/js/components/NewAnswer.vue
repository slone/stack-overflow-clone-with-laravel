<template>
	<div class="row mt-4 justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="card-title">
						<h3>Your answer</h3>
					</div>
					<hr>
					<form @submit.prevent="create">
						<div class="form-group">
							<textarea class="form-control" rows="7" name="body" v-model="body" required></textarea>
						</div>							
						<div class="form-group">
							<button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	props:['questionId'],
	data() {
		return {
			body: '',
		}
	},
	computed: {
		isInvalid() {
			return !this.signedIn || this.body.length < 20;
		}
	},
	methods: {
		create() {
			axios.post(`/questions/${this.questionId}/answers`, {
				body: this.body
			})
			.then(({data}) => {
				this.$toast.success(data.message, "Success");
				this.body = '';
				let newAnswer = data.answer;
				this.$emit("new-answer-added", data.answer);
			})
			.catch(err => {
				this.$toast.error(err.response.data.message, 'Error');
			});
		}
	}
}
</script>