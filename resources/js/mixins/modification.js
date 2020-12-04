import destroy from './destroy';
export default {
	mixins: [destroy],
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
		setEditCache() {},
		restoreFromCache() {},
		payload() {},
	}
}