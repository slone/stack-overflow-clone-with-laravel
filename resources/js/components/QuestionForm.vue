<template>
	<form @submit.prevent="handleSubmit">
		<div class="form-group">
			<label for="question-title">Question title</label>
			<input type="text" name="title" v-model="title" class="form-control" :class="errorClass('title')">
			
			<div v-if="errors['title'].length" class="invalid-feedback">
				<strong>{{ errors['title'][0] }}</strong>
			</div>
		</div>
		<div class="form-group">
			<label for="question-body">Explain your concern</label>
			<textarea name="body" rows="10" v-model="body" class="form-control" :class="errorClass('body')"></textarea>
			
			<div v-if="errors['body'].length" class="invalid-feedback">
				<strong>{{ errors['body'][0] }}</strong>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg" :disabled="$root.isLoading">
				<div v-if="$root.isLoading" class="submitting-status">
					{{ buttonTextSubmitting }}
					<loading-spinner :small="true"></loading-spinner>
				</div>
				<div v-else class="waiting-status"> {{ buttonText }}</div>
			</button>
		</div>
	</form>
	
</template>
<script>
import EventBus from '../event-bus';
export default {
	props: {
		isEdit: { 
			type: Boolean,
			default: false,
		}
	},
	data(){
		return {
			isBeingSubmitted: false,
			body: null,
			title: null,
			errors: {
				title: [],
				body: [],
			},
			blankErrors: {
				title: [],
				body: [],
			}
		}
	},
	computed:{
		buttonText() {
			return this.isEdit ? "Apply modifications to your question" : "Ask your question";
		},
		buttonTextSubmitting() {
			return this.isEdit ? "Submitting modifications" : "Submitting your question";
		},
	},
	methods:{
		handleSubmit() {
			this.$emit('question-form-submitted', {
				title: this.title,
				body: this.body,
			});
		},
		errorClass(field) {
			return this.errors[field] && this.errors[field].length ? 'is-invalid': ''	
		},
		setErrors(field, value) {
			this.errors[field] = value;
		},
		unsetErrors() {
			this.errors = JSON.parse(JSON.stringify(this.blankErrors));
		},
		fetchQuestion() {
			axios
			.get(`/questions/${this.$route.params.id}`)
			.then( ({data}) => {
				this.title = data.title;
				this.body = data.body;
			})
			.catch( ({response})=> {
				this.$toast.error(response.data.message, 'Error');
			});
		}
	},
	mounted() {
		this.$root.isLoading = false; // bad practise, but quick fix. The good way would be using vuex or equivalent
		EventBus.$on('question-form-error', errors => {
			this.unsetErrors()
			for (const field in errors) {
				let error = errors[field];
				this.setErrors(field, error);
			}
		});

		if (this.isEdit) {
			this.fetchQuestion();
		}
	},
}
</script>
<style scoped lang="scss">
.submitting-status {
	display: flex;
	.spinner-wrapper {
		margin-left: 1em;
	}
}

</style>