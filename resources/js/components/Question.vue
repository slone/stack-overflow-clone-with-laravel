<template>
	<div class="row justify-content-center question-wrapper">
		<div class="col-md-8">
			<div class="card">

				<form class="card-body" v-if="editing" @submit.prevent="update">
					<div class="card-title">
						<div class="d-flex align-items-center">
							<input type="text" v-model="title" class="form-control form-control-lg">
						</div>
					</div>

					<hr>
					<div class="media">
						<div class="media-body">
							<div class="form-group">
								<textarea required v-model="body" rows="10" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" type="submit" :disabled="isInvalid">Update</button>
								<button class="btn btn-outline-secondary" type="button" @click.prevent="cancel">Cancel</button>
							</div>
						</div>
					</div>
				</form>

				<div class="card-body p1" v-else>
					<div class="card-title">
						<div class="d-flex align-items-center">
							<h1>{{ title }}</h1>
							<div class="ml-auto">
								<a href="/questions" class="btn btn-outline-secondary">Back to questions</a>
							</div>
						</div>
					</div>

					<hr>

					<div class="media">

						<vote-buttons :model="question" name="question"></vote-buttons>

						<div class="media-body">
							<div v-html="bodyHtml"></div>

							<footer v-if="!editing" class="row answer-infos">
								<div class="col-4 owner-controls">
									<div class="ml-auto">
										<a 			v-if="authorize('modify', question)" @click.prevent="edit" 	href="#" 		class="btn btn-sm btn-outline-info">Edit</a>
										<button 	v-if="authorize('deleteQuestion', question)" @click.prevent="destroy" type="button" 	class="btn btn-sm btn-outline-danger">Delete</button>
									</div>								
								</div>
								<div class="col-3"></div>
								<div class="col-5">
									<user-info :model="question" label="asked"></user-info>
								</div>
							</footer>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</template>
<script>
import UserInfo from './UserInfo';
import VoteButtons from './VoteButtons';
import modification from '../mixins/modification';

export default {
	props: ['question'],
	components: {UserInfo, VoteButtons},
	mixins: [modification],
	data() {
		return {
			id: this.question.id,
			title: this.question.title,
			body: this.question.body,
			bodyHtml: this.question.body_html,
			beforeEditCache: {},
		}
	},
	computed: {
		isInvalid() {
			return this.body.length < 40 || this.title.length < 10;
		},
		endpoint() {
			return `/questions/${this.id}`;
		}
	},
	methods: {
		setEditCache() {
			this.beforeEditCache = {
				body: this.body,
				title: this.title,	
			};
		},
		restoreFromCache() {
			this.body = this.beforeEditCache.body;
			this.title = this.beforeEditCache.title;
		},
		payload() {
			return {
				body: this.body,
				title: this.title,
			};
		},
		delete() {
			axios.delete(this.endpoint)
			.then( ({ data }) => {
				let msg = data.message + "<br>You will be redirected to the question list in a few seconds.";
				this.$toast.success(msg, 'Success', { 
					timeout: 7000,				
					onClosed() {
						window.location.href = "/questions";
					} 
				});
			})
			.catch( ({ response }) => {
				this.$toast.error(response.data.message, 'Error',  { timeout: 4000 });
			});
		},
	}
}
</script>