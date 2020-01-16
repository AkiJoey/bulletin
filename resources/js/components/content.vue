<template>
	<div id="content">
		<el-card class="box-card" v-for="(article, index) in articles" :key="index">
			<div slot="header" class="clearfix">
				<span class="title">{{article.title}}</span>
				<div class="tags">
					<el-tag class="tag" size="medium" v-for="(tag, index) in article.tags" :key="index">{{tag}}</el-tag>
				</div>
				<div class="button">
					<el-button size="small" type="danger" icon="el-icon-delete" @click="articleDelete(index)">Delete</el-button>
				</div>
			</div>
			<div class="text" v-html="article.content"></div>
		</el-card>
	</div>
</template>

<script>
    export default {
		data() {
			return {
				articles: null
			}
		},
		created() {
			axios.get('http://localhost:8000/api/article/get')
			.then(response => {
				this.articles = response.data;
				console.log(response);
			})
			.catch(error => {
				console.log(error);
			});
		},
		props: ['article'],
		watch: {
			article(article) {
				console.log(article);
				this.articles.push(article);
			}
		},
		methods: {
			articleDelete(index) {
				axios.delete('http://localhost:8000/api/article/delete?id=' + this.articles[index].id)
				.then(response => {
					this.articles.splice(index, 1);
					this.$message.success('Delete success.');
					console.log(response);
				})
				.catch(error => {
					this.$message.error('Delete error.');
					console.log(error);
				});
			}
		}
	}
</script>

<style>

</style>