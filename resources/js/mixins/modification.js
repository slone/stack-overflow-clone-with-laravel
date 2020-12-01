export default {
	data() {
		return {
			editing: false,
		}
	},

	methods: {
		edit() {
			this.setEditCache();
			this.editing = true;
		},
		cancel() {
			this.restoreFromCache();
			this.editing = false;
		},
		update() {
			axios.put(this.endpoint, this.payload())
			.catch(({response}) => {
				this.$toast.error(reponse.data.message, "Error", {timeout: 3000 });
			})
			.then(({data}) => {
				this.bodyHtml = data.body_html;
				this.$toast.success(data.message, "Success", {timeout: 3000});
				this.editing = false;
			});
		},
		destroy() {
			this.$toast.question('<p>Are you sure you wish to delete this question?</p>\r\n<p><strong>This cannot be undone!</strong></p>', 'Confirm deletion', {
				timeout: 4000,
				close: false,
				overlay: true,
				displayMode: 'once',
				id: 'question',
				zindex: 999,
				title: 'Hey',
				position: 'center',
				buttons: [
					['<button><b>YES</b></button>', (instance, toast) => {

						this.delete();
						
						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}, true],
					['<button>NO</button>', function (instance, toast) {

						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}],
				],

			});
		},
		setEditCache() {},
		restoreFromCache() {},
		payload() {},
		delete() {},
	}
}