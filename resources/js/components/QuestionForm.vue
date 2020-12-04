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
			<button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg">{{ buttonText }}</button>
		</div>
	</form>
	
</template>
<script>
import EventBus from '../event-bus';
export default {
	data(){
		return {
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
			return "Ask your question";
		}
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
		}
	},
	mounted() {
		EventBus.$on('question-form-error', errors => {
			this.unsetErrors()
			for (const field in errors) {
				let error = errors[field];
				this.setErrors(field, error);
			}
		});
	},
}
</script>