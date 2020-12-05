<template>
<div class="spinner-wrapper">
	<font-awesome-icon :icon="['fas', 'spinner']" :size="size" :class="makeSpace" pulse />
</div>
</template>
<script>
export default {
	props: {
		small: {
			type: Boolean,
			default: false,
		}
	},
	computed: {
		size() {
			return this.small ? '' : '5x';
		},
		makeSpace() {
			return this.small ? '' : 'make-space';
		}
	},
}
</script>
<style scoped>
.spinner-wrapper {
	color: #3490dc; 
	text-align: center;
}
.make-space {
	margin: 1em 0;
}
</style>