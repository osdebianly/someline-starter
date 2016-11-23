<template>
    <div>
        <el-button icon="plus" type="success" class="pull-right" style="margin-right: 50px" @click="handleAdd">新增
        </el-button>
        <el-table
                v-loading.body="loading"
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    label="ID"
                    prop="id"
                    width="100"
                    sortable>
            </el-table-column>
            <el-table-column
                    inline-template
                    label="角色名称"
            >
                <el-popover trigger="hover" placement="top">
                    <p>名称: {{ row.name }}</p>
                    <p>角色: {{ row.slug }}</p>
                    <p>等级: {{ row.level }}</p>
                    <div slot="reference">
                        <el-tag>{{ row.name }}</el-tag>
                    </div>
                </el-popover>
            </el-table-column>

            <el-table-column
                    label="角色"
                    prop="slug">
            </el-table-column>

            <el-table-column
                    label="描述"
                    prop="description"
            >
            </el-table-column>
            <el-table-column
                    inline-template
                    label="创建时间"
            >
                <div>
                    <el-icon name="time"></el-icon>
                    <span style="margin-left: 10px">{{ row.created_at }}</span>
                </div>
            </el-table-column>

            <el-table-column
                    inline-template
                    label="更新时间"
            >
                <div>
                    <el-icon name="time"></el-icon>
                    <span style="margin-left: 10px">{{ row.updated_at }}</span>
                </div>
            </el-table-column>

            <el-table-column
                    :context="_self"
                    inline-template
                    label="操作">
                <div>
                    <el-button
                            size="small"
                            @click="handleEdit($index, row)">
                        编辑
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete($index, row)">
                        删除
                    </el-button>
                </div>
            </el-table-column>
        </el-table>

        <el-dialog title="编辑菜单" v-model="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="角色名称" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="角色" :label-width="formLabelWidth">
                    <el-input v-model="form.slug" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="描述" :label-width="formLabelWidth">
                    <el-input v-model="form.description" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="等级" :label-width="formLabelWidth">
                    <el-input v-model="form.level" auto-complete="off"></el-input>
                </el-form-item>

            </el-form>

            <el-checkbox-group v-model="permissionSelectd">
                <el-checkbox v-for="permission in permissionData" :label="permission"></el-checkbox>
            </el-checkbox-group>

            <div slot="footer" class="dialog-footer">
                <el-button @click.native="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="onSubmit()">确 定</el-button>
            </div>
        </el-dialog>


    </div>

</template>

<script>
    var resource = {};
    var self = {};

    export default {
        data() {
            return {
                tableData: [],
                permissionData: [],
                permissionSelectd: [],
                dialogFormVisible: false,
                form: {},
                formLabelWidth: '120px',
                loading: true
            }
        },
        methods: {
            handleEdit(index, row) {
                //console.log(index, row);
                this.form = row;
                this.$http.get("/admin/roles/" + row.id + "/permissions")
                        .then(function (response) {
                            this.permissionSelectd = response.data;
                        });
                this.dialogFormVisible = true;
            },
            handleAdd() {
                //console.log('add role');
                this.form = {};
                this.permissionSelectd = [];
                this.dialogFormVisible = true;

            },
            handleDelete(index, row) {
                //console.log(index, row);

                this.$confirm('此操作将永久删除' + row.name + ', 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function () {
                    console.log('res' + resource);
                    resource.delete({id: row.id}).then(function (response) {
                        self.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                        this.initData();
                    });

                }).catch(function () {
                    self.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });

            },
            onSubmit(){

                if (this.form.id) {
                    resource.update({id: this.form.id}, {
                        roleData: this.form,
                        permissionData: this.permissionSelectd
                    }).then(function (response) {
                        //console.log(response.data);
                        if (response.data.message) {
                            self.$message(response.data.message);
                            this.initData();
                        }

                    });
                } else {
                    resource.save({}, {
                        roleData: this.form,
                        permissionData: this.permissionSelectd
                    }).then(function (response) {
                        //console.log(response.data);
                        if (response.data.message) {
                            self.$message(response.data.message);
                            this.initData();
                        }
                    });
                }
            },
            initData(){
                this.dialogFormVisible = false;
                this.form = {};
                resource.get({id: "all"}).then(function (response) {
                    //console.log(response.data);
                    this.tableData = response.data;
                    this.loading = false;
                });
            }

        },
        mounted(){
            self = this;
            resource = this.$resource('/admin/roles{/id}', {});
            this.initData();
            this.$http.get("/admin/permissions/list")
                    .then(function (response) {
                        console.log('permission' + response.data);
                        this.permissionData = response.data;
                    });
        }
    }


</script>