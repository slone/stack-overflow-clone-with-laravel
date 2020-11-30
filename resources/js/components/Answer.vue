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
				this.$toast.success(err.response.data.message, 'Success', { timeout: 3000 });
			})
			.catch(err => {
				console.error(err.response.data.message);
				this.$toast.error(err.response.data.message, 'Error', { timeout: 3000 });
			});
		},
		destroy() {
			this.$toast.question('<p>Are you sure you wish to delete this answer?</p>\r\n<p><strong>This cannot be undone!</strong></p>', 'Confirm deletion', {
				timeout: 20000,
				close: false,
				overlay: true,
				displayMode: 'once',
				id: 'question',
				zindex: 999,
				title: 'Hey',
				position: 'center',
				buttons: [
					['<button><b>YES</b></button>', (instance, toast) => {
						axios.delete(this.endpoint)
						.then( res => {
							$(this.$el).fadeOut(500, () => {
								this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
							})
						});

						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}, true],
					['<button>NO</button>', function (instance, toast) {

						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}],
				],
			});
		}
	}
}
</script>