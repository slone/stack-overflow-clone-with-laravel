<script>
export default {
	props: ['answer'],
	data() {
		return {
			editing: false,
			body: this.answer.body,
			bodyHtml: this.answer.body_html,
			id: this.answer.id,
			questionId: this.answer.question_id,
			beforeEditCache: null,
		}
	},

	computed: {
		isInvalid() {
			return this.body.length < 40;
		},
		endpoint() {
			return `/questions/${this.questionId}/answers/${this.id}`;
		}
	},

	methods: {
		edit() {
			this.editing = true;
			this.beforeEditCache = this.body;
		},
		cancel() {
			this.editing = false;
			this.body = this.beforeEditCache;
		},
		update() {

			axios.patch(this.endpoint, {
				body: this.body,
			})
			.then(res => {
				this.bodyHtml = res.data.body_html;
				this.editing=false;
			})
			.catch(err => {
				console.error(err.response.data.message);
				alert(err.response.data.message)
			});
		},
		destroy() {
			if (confirm('Are you sure?')) {

				axios.delete(this.endpoint)
				.then( res => {
					$(this.$el).fadeOut(500, () => {
						alert(res.data.message)
					})
				});
			}	
		}
	}
}
</script>