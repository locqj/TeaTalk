<template>
	<div class="imgbox">
		<uploader :src="url" @transferImg="getImg"></uploader>
		
	</div>
</template>
<script>
	import uploader from './Uploads.vue'
	export default {
		name: '',
		props: ['url'],
		data () {
			return {
				img
			}
		},
		methods: {
			getImg (img) {
				this.img = img
				console.log(this.img)
			}
		},
		components: {
			uploader
		}
	}
</script>
<style type="text/css">
	.imgbox{
		margin-top: 5px;
		width: 100%
	}
</style>