export default {
	methods: {
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
		delete() {},

	}
}