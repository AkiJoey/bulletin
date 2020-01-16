<template>
	<div id="header">
		<!-- nav -->
		<div id="nav">
			<img id="logo" src="favicon.ico" alt="logo" />
			<div id="title">BulletinBoard</div>
			<div id="btn">
				<el-tooltip effect="dark" content="Insert" placement="bottom" :open-delay="300">
					<el-button type="primary" icon="el-icon-edit" circle @click="dialogVisible = true"></el-button>
				</el-tooltip>
				<el-tooltip effect="dark" content="AkiJoey" placement="bottom" :open-delay="300">
					<a href="https://akijoey.com"><el-avatar size="large" src="avatar.png"></el-avatar></a>
				</el-tooltip>
			</div>
		</div>
		<!-- dialog -->
		<el-dialog title="Insert" :visible.sync="dialogVisible" width="35%">
			<el-input type="text" placeholder="Please input title." v-model="title" maxlength="15" show-word-limit></el-input>
			<el-input type="textarea" placeholder="Please input content." v-model="content" maxlength="300" rows="8" show-word-limit></el-input>
			<div id="tags">
				<el-tag v-for="tag in tags" :key="tag" closable @close="tagClose(tag)">{{tag}}</el-tag>
				<el-input v-if="inputVisible" class="input-new-tag" v-model="inputValue" ref="saveTagInput" size="small" @keyup.enter.native="tagConfirm" @blur="tagConfirm"></el-input>
				<el-button v-else class="button-new-tag" size="small" @click="inputShow">+ New Tag</el-button>
			</div>
			<span slot="footer" class="dialog-footer">
				<el-button size="medium" @click="dialogVisible = false">Cancel</el-button>
				<el-button size="medium" type="primary" @click="dialogConfirm">Confirm</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
    export default {
		data() {
			return {
				title: '',
				content: '',
				tags: [],
				inputValue: '',
				inputVisible: false,
				dialogVisible: false
			}
		},
		methods: {
			tagClose(tag) {
				this.tags.splice(this.tags.indexOf(tag), 1);
			},

			inputShow() {
				this.inputVisible = true;
				this.$nextTick(_ => {
					this.$refs.saveTagInput.$refs.input.focus();
				});
			},

			tagConfirm() {
				if (this.inputValue)
					this.tags.push(this.inputValue);
				this.inputVisible = false;
				this.inputValue = '';
			},

			dialogConfirm() {
				if (this.title == '')
					this.$message.warning('Please input title.');
				else if (this.content == '')
					this.$message.warning('Please input content.');
				else if (this.tags == false)
					this.$message.warning('Please input tag.');
				else
					this.formPost();
			},

			formPost() {
				this.dialogVisible = false;
				axios.post('http://localhost:8000/api/article/post', {
					title: this.title,
					tags: this.tags,
					content: this.content.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, '&nbsp;')
				})
				.then(response => {
					this.$emit('insert', response.data);
					this.$message.success('Insert success.');
					console.log(response);
					this.initialize();
				})
				.catch(error => {
					this.$message.error('Insert error.');
					console.log(error);
				});
			},

			initialize() {
				this.title = '';
				this.content = '';
				this.tags = [];
			}
		}
	}
</script>

<style>
	
</style>