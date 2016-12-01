<template>
    <div>
        <el-row :gutter="20">
            <el-col :span="4" :offset="8">
                <div class="input-group">
                    <input type="text" v-model="search" class="form-control input-sm bg-light no-border rounded padder"
                           placeholder="Search ...">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-sm bg-light rounded"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </el-col>
            <el-col :span="5" :offset="6">
                <el-radio class="radio" v-model="type" label="wait">待审核</el-radio>
                <el-radio class="radio" v-model="type" label="success">成功</el-radio>
                <el-radio class="radio" v-model="type" label="fail">失败</el-radio>
                <el-radio class="radio" v-model="type" label="all">所有</el-radio>
            </el-col>
        </el-row>


        <el-table
                v-loading.body="loading"
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    inline-template
                    label="ID"
                    width="100"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.id }}</span>
                </div>
            </el-table-column>
            <el-table-column
                    inline-template
                    label="状态"
                    width="100"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.state }}</span>
                </div>
            </el-table-column>

            <el-table-column
                    inline-template
                    label="图片"
            >
                <el-popover trigger="click" placement="top">
                    <img :src="row.pic_url">
                    <div slot="reference" class="name-wrapper">
                        <el-tag>点击查看图片</el-tag>
                    </div>
                </el-popover>
            </el-table-column>
            <el-table-column
                    inline-template
                    label="消息"
                    width="400"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.message }}</span>
                </div>
            </el-table-column>

            <el-table-column
                    :context="_self"
                    inline-template
                    label="操作"
                    width="200"
            >
                <div>
                    <el-button
                            size="small"
                            @click="handlePass($index, row)">
                        通过
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleReject($index, row)">
                        拒绝
                    </el-button>
                </div>
            </el-table-column>
            <el-table-column
                    inline-template
                    label="备注"
                    width="200"
            >
                <div>
                    <el-input
                            placeholder="这里输入拒绝理由"
                            v-model="row.note">
                    </el-input>
                </div>
            </el-table-column>
        </el-table>


    </div>

</template>

<script>
    var resource = {};
    var self = {};
    var list = [];

    export default {
        data() {
            return {
                tableData: [],
                formLabelWidth: '120px',
                loading: true,
                search: '',
                type: 'wait'
            }
        },
        watch: {
            search: function (val, oldVal) {
                console.log('new: %s, old: %s', val, oldVal);
                var result = [];
                list.forEach(function (row) {
                    if (row.state.indexOf(val) != -1 || row.message.indexOf(val) != -1) {
                        result.push(row);
                    }
                });
                this.tableData = result;
            },
            type: function (val, oldVal) {
                console.log('new: %s, old: %s', val, oldVal);
                this.loading = true;
                this.initData()

            },
        },
        methods: {
            handlePass(index, row) {
                //队列通知服务端加金币
                this.$confirm('确定用户ID ' + row.user_id + ' ,通过审核?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function () {

                    console.log('row' + row);
                    resource.update({id: row.id}, {state: 'success', note: row.note}).then(function (response) {
                        self.$message({
                            type: 'success',
                            message: '通过审核!'
                        });
                    });
                    //移除当前待处理任务
                    self.tableData.splice(index, 1);

                }).catch(function () {
                    self.$message({
                        type: 'info',
                        message: '已取消'
                    });
                });


            },

            handleReject(index, row) {
                //console.log(index, row);

                //队列通知服务端加金币
                this.$confirm('拒绝用户 ' + row.user_id + ',通过审核?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(function () {
                    console.log('row' + row);
                    resource.update({id: row.id}, {state: 'fail', note: row.note}).then(function (response) {
                        self.$message({
                            type: 'warning',
                            message: '拒绝本次提交!'
                        });
                    });
                    //移除当前待处理任务
                    self.tableData.splice(index, 1);

                }).catch(function () {
                    self.$message({
                        type: 'info',
                        message: '已取消'
                    });
                });
            },
            initData(){
                this.dialogFormVisible = false;
                this.form = {};
                resource.get({id: this.type}).then(function (response) {
                    this.tableData = response.data;
                    list = response.data;
                    this.loading = false;
                });
            }

        },
        mounted(){
            self = this;
            resource = this.$resource('/admin/activities/good_reputation{/id}', {});
            this.initData();
        }
    }


</script>