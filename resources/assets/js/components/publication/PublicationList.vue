<template>
    <div>

        <el-row :gutter="20" v-loading.body="loading">

            <el-col :span="4">

                <el-button icon="plus" type="info" @click="handleAdd">新增</el-button>
                <div class="line line-lg b-b b-light"></div>

                <el-menu default-active="0" theme="dark" @select="handleSelect">

                    <el-menu-item v-for="(item,index) in publications" :index="toString(index)">{{ item.name }}
                    </el-menu-item>

                </el-menu>

            </el-col>
            <el-col :span="20">
                <div v-show="! loading">
                    <el-row>
                        <el-steps :active="active">
                            <el-step title="基本" icon="edit"></el-step>
                            <el-step title="公告" icon="edit"></el-step>
                            <el-step title="在线" icon="edit"></el-step>
                            <el-step title="服务器" icon="edit"></el-step>
                            <el-step title="热更" icon="edit"></el-step>
                            <el-step title="白名单" icon="edit"></el-step>
                            <el-step title="完成" icon="check"></el-step>
                        </el-steps>
                    </el-row>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <el-row v-show="active == 1">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-11 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">基本配置</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication" :rules="rules" ref="basic"
                                             :label-width="formLabelWidth">
                                        <el-form-item label="包名称" prop="package_name">
                                            <el-input v-model="publication.package_name"></el-input>
                                        </el-form-item>
                                        <el-form-item label="最小版本" prop="min_version">
                                            <el-input v-model="publication.min_version"></el-input>
                                        </el-form-item>
                                        <el-form-item label="最大版本" prop="max_version">
                                            <el-input v-model="publication.max_version"></el-input>
                                        </el-form-item>
                                        <el-form-item label="开始时间" prop="min_time">
                                            <el-date-picker type="datetime" format="yyyy-MM-dd HH:mm:ss"
                                                            placeholder="选择日期" v-model="publication.min_time"
                                                            style="width: 100%;"></el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="结束时间" prop="max_time">
                                            <el-date-picker type="datetime" format="yyyy-MM-dd HH:mm:ss"
                                                            placeholder="选择日期" v-model="publication.max_time"
                                                            style="width: 100%;"></el-date-picker>

                                        </el-form-item>

                                        <el-form-item label="备注">
                                            <el-input type="textarea" v-model="publication.note"></el-input>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="handleNext">下一步</el-button>

                                        </el-form-item>
                                    </el-form>

                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 2">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">登录公告配置</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication" ref="publication" :label-width="formLabelWidth">

                                        <el-form-item label="登录公告">
                                            <el-input type="textarea" :rows=5
                                                      v-model="publication.publication_message"></el-input>
                                        </el-form-item>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span=2 :offset=2>
                                                    <el-button type="warning" @click="handleBefore">上一步</el-button>

                                                </el-col>
                                                <el-col :span=2 :offset=2>
                                                    <el-button type="primary" @click="handleNext">下一步</el-button>

                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 3">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">在线配置</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication" :label-width="formLabelWidth">
                                        <el-form-item
                                                v-for="(config,index) in publication.online_config"
                                                :label="'配置' + index">
                                            <el-row>
                                                <el-col :span="6">
                                                    <el-input v-model="config.key"></el-input>
                                                </el-col>
                                                <el-col :span="11" :offset="1">
                                                    <el-input v-model="config.value"></el-input>
                                                </el-col>
                                                <el-col :span="5" :offset="1">
                                                    <el-button type="danger"
                                                               @click.native.prevent="removeOnlineConfig(config)">删除
                                                    </el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="5" :offset="9">
                                                    <el-button type="success" @click.native.prevent="addOnlineConfig()">
                                                        添加
                                                    </el-button>

                                                </el-col>

                                            </el-row>
                                        </el-form-item>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            {{publication.online_config}}
                                        </el-form-item>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="warning" @click="handleBefore">上一步</el-button>

                                                </el-col>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="primary" @click="handleNext">下一步</el-button>

                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 4">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">服务器列表</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication" :label-width="formLabelWidth" class="demo-ruleForm">

                                        <el-form-item
                                                v-for="(config,index) in publication.server_list"
                                                :label="'服务器 ' + index">
                                            <el-row>
                                                <el-col :span="8">
                                                    <el-input v-model="config.value"></el-input>
                                                </el-col>
                                                <el-col :span="5" :offset="1">
                                                    <el-button type="danger"
                                                               @click.native.prevent="removeServer(config)">删除
                                                    </el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>

                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="3" :offset="4">
                                                    <el-button type="success" @click.native.prevent="addServer()">添加
                                                    </el-button>

                                                </el-col>

                                            </el-row>
                                        </el-form-item>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        {{publication.server_list}}
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="warning" @click="handleBefore">上一步</el-button>

                                                </el-col>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="primary" @click="handleNext">下一步</el-button>

                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 5">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">热更配置</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication.hot_upgrade" :rules="rules"
                                             :label-width="formLabelWidth">
                                        <el-form-item label="git公共仓库" prop="git_url">
                                            <el-input v-model="publication.hot_upgrade.git_url"></el-input>
                                        </el-form-item>

                                        <el-form-item label="分支" prop="git_branch">
                                            <el-row>
                                                <el-col :span="8">
                                                    <el-input v-model="publication.hot_upgrade.git_branch"></el-input>
                                                </el-col>
                                                <el-col :span="5" :offset="1">
                                                    <el-button type="danger" @click.native.prevent="handleCheckOut()">
                                                        检出
                                                    </el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="warning" @click="handleBefore">上一步</el-button>
                                                </el-col>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="primary" @click="handleNext">下一步</el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 6">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-info no-border">
                                        <span class="text-u-c m-b-none font-bold">测试白名单列表</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :model="publication" :rules="rules" :label-width="formLabelWidth"
                                             class="demo-ruleForm">

                                        <el-form-item
                                                v-for="(config,index) in publication.uuids"
                                                :label="'UUID ' + index">
                                            <el-row>
                                                <el-col :span="8">
                                                    <el-input v-model="config.value"></el-input>
                                                </el-col>
                                                <el-col :span="5" :offset="1">
                                                    <el-button type="danger" @click.native.prevent="removeUUID(config)">
                                                        删除
                                                    </el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>

                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="3" :offset="4">
                                                    <el-button type="success" @click.native.prevent="addUUID()">添加
                                                    </el-button>

                                                </el-col>

                                            </el-row>
                                        </el-form-item>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="warning" @click="handleBefore">上一步</el-button>

                                                </el-col>
                                                <el-col :span="2" :offset="2">
                                                    <el-button type="primary" @click="handleNext">下一步</el-button>

                                                </el-col>
                                            </el-row>
                                        </el-form-item>

                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>
                    <el-row v-show="active == 7">
                        <div class="row row-sm">
                            <div class="col-lg-11 col-md-12 col-sm-12">
                                <div class="panel b-a">
                                    <div class="panel-heading text-center bg-success no-border">
                                        <span class="text-u-c m-b-none font-bold">完成配置</span>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <el-form :label-width="formLabelWidth" class="demo-ruleForm">
                                        <el-form-item>
                                            <el-row>
                                                <el-col :span="5" :offset="10">
                                                    <el-button type="success" size="large"
                                                               @click.native.prevent="onSubmit()">保存
                                                    </el-button>
                                                </el-col>
                                            </el-row>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="warning" @click="handleBefore">上一步</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                    </el-row>

                </div>
            </el-col>

        </el-row>

    </div>

</template>

<style>
</style>

<script>
    var resource = {};
    var self = {};

    export default{
        data(){
            return {
                publications: {},
                publication: {
                    id: 0,
                    package_name: 'com.xxxx',
                    min_version: '0.0.1',
                    max_version: '1.0.0',
                    min_time: '',
                    max_time: '',
                    note: '~~这里添加备注~~',
                    online_config: [{key: 'Config Key', value: 'Config Value'}],
                    publication_message: '欢迎登陆~~',
                    //基本配置
                    server_list: [{value: 'server1'}],
                    hot_upgrade: {
                        git_url: 'http://',
                        git_branch: 'master',
                        package_name: '',
                        backup_donwload_url: ''
                    },
                    uuids: [{value: 'uuid'}]

                },
                rules: {
                    package_name: [
                        {required: true, message: '请输入包名称', trigger: 'blur'},
                        {min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur'}
                    ],
                    min_version: [
                        {required: true, message: '请输入最小版本', trigger: 'change'}
                    ],
                    max_version: [
                        {required: true, message: '请输入最大版本', trigger: 'change'}
                    ],
                    min_time: [
                        {type: 'date', required: true, message: '请选择开始日期', trigger: 'change'}
                    ],
                    max_time: [
                        {type: 'date', required: true, message: '请选择结束时间', trigger: 'change'}
                    ],
                    git_url: [
                        {required: true, message: '请输入git 仓库地址(公开)', trigger: 'change'},
                        {type: 'url', message: '请输入有效 URL', trigger: 'change'}
                    ],
                    git_branch: [
                        {required: true, message: '请输入分支名称,默认master', trigger: 'change'}
                    ]
                },
                formLabelWidth: '120px',
                loading: true,
                active: 1,

            }
        },
        watch: {},
        methods: {
            addUUID() {
                this.publication.uuids.push({
                    value: 'UUID'
                });
            },
            removeUUID(config) {
                var index = this.publication.uuids.indexOf(config);
                if (index !== -1) {
                    this.publication.uuids.splice(index, 1);
                }
            },

            handleCheckOut(){
                this.publication.hot_upgrade.package_name = this.publication.package_name;
                this.$http.post('/admin/publications/checkout', this.publication.hot_upgrade).then(function (response) {
                    self.publication.hot_upgrade.backup_donwload_url = response.data.data.download_url;
                    self.$notify.success({
                        title: '成功',
                        message: response.data.message
                    });
                }).catch(function (response) {
                    self.$notify.error({
                        title: '错误',
                        message: response.data.message
                    });
                });

            },

            removeOnlineConfig(config) {
                console.log('remove config ' + config);
                var index = this.publication.online_config.indexOf(config);
                if (index !== -1) {
                    this.publication.online_config.splice(index, 1);
                }
            },
            addOnlineConfig() {
                this.publication.online_config.push({
                    key: 'OnlineKey',
                    value: 'OnlineValue'
                });
            },
            removeServer(config) {
                console.log('remove config ' + config);
                var index = this.publication.server_list.indexOf(config);
                if (index !== -1) {
                    this.publication.server_list.splice(index, 1);
                }

            },
            addServer() {
                this.publication.server_list.push({value: 'Server IP'});
            },
            handleNext(){
                if (this.active++ > 6) {
                    this.active = 1;
                }
            },
            handleBefore(){
                if (this.active-- < 1) {
                    this.active = 6;
                }
            },

            handleSelect(index, row) {
                console.log(index);
                this.$confirm('此操作将丢弃当前编辑内容, 是否继续?', '提示', {
                    confirmButtonText: '确定切换',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function () {
                    console.log('handleSelect');
                    self.publication = JSON.parse(JSON.stringify(self.publications[index]));
                    console.log('new publication:' + self.publication);
                    self.publication.min_time = new Date(Date.parse(self.publication.min_time.replace(/-/g, "/")));
                    self.publication.max_time = new Date(Date.parse(self.publication.max_time.replace(/-/g, "/")));

                    self.$message({
                        type: 'success',
                        message: '切换到 !' + self.publication.package_name
                    });
                }).catch(function () {
                    self.$message({
                        type: 'info',
                        message: '已取消切换'
                    });
                });


            },
            handleSelectFirst() {
                if (this.publications.length == 0) {
                    return false;
                }
                this.publication = JSON.parse(JSON.stringify(this.publications[0]));

                this.publication.min_time = new Date(Date.parse(this.publication.min_time.replace(/-/g, "/")));
                this.publication.max_time = new Date(Date.parse(this.publication.max_time.replace(/-/g, "/")));

                this.$message({
                    type: 'success',
                    message: '切换到 !' + this.publication.package_name
                });

            },
            handleAdd() {
                //console.log('add role');
                this.redirectToUrlFromBaseUrl('admin/publications/add');
            },
            //todo 提交数据
            onSubmit(){

                console.log(JSON.stringify(this.publication));

                resource.update({id: this.publication.id}, this.publication).then(function (response) {
                    console.log(response.data);
                    self.$notify.info({title: '成功', message: response.data.message});
                }).catch(function (response) {
                    self.$notify.error({title: '错误', message: response.data.message});

                });


            },
            initData(){
                this.dialogFormVisible = false;
                this.form = {};
                resource.get({id: "all"}).then(function (response) {
                    //console.log(response.data);
                    this.publications = response.data;
                    this.handleSelectFirst();
                    this.loading = false;
                });
            }

        },
        mounted() {
            self = this;
            console.log('User List Ready.');
            resource = this.$resource('/admin/publications{/id}', {});
            this.initData();

        }
    }
</script>