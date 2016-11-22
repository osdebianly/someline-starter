<template>
    <div>
        <el-button icon="plus" type="success" class="pull-right" style="margin-right: 50px" @click="handleAdd">新增
        </el-button>
        <el-table
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    inline-template
                    label="ID"
                    width="180"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.id }}</span>
                </div>
            </el-table-column>
            <el-table-column
                    inline-template
                    label="用户名"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.name }}</span>
                </div>
            </el-table-column>

            <el-table-column
                    inline-template
                    label="邮箱"
            >
                <div>
                    <span style="margin-left: 10px">{{ row.email }}</span>
                </div>
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
                <el-form-item label="用户名" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" :label-width="formLabelWidth">
                    <el-input v-model="form.email" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" :label-width="formLabelWidth">
                    <el-input v-model="form.password" auto-complete="off"></el-input>
                </el-form-item>

            </el-form>

            <div>
                <el-tag type="primary">角色列表</el-tag>
                <el-checkbox-group v-model="roleSelectd">

                    <el-checkbox v-for="role in roleData" :label="role"></el-checkbox>

                </el-checkbox-group>
            </div>
            <br/>
            <div>
                <el-tag type="primary">权限列表</el-tag>
                <el-checkbox-group v-model="permissionSelectd">

                    <el-checkbox v-for="permission in permissionData" :label="permission"></el-checkbox>

                </el-checkbox-group>
            </div>


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
                roleData: [],
                roleSelectd: [],

                dialogFormVisible: false,
                form: {},
                formLabelWidth: '120px'
            }
        },
        methods: {
            handleEdit(index, row) {
                //console.log(index, row);
                this.form = row;
                this.$http.get("/admin/admins/" + row.id + "/roles")
                        .then(function (response) {
                            this.roleSelectd = response.data;
                        });
                this.$http.get("/admin/admins/" + row.id + "/permissions")
                        .then(function (response) {
                            this.permissionSelectd = response.data;
                        });
                this.dialogFormVisible = true;
            },
            handleAdd() {
                //console.log('add role');
                this.form = {};
                this.permissionSelectd = [];
                this.roleSelectd = [];
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
                        adminData: this.form,
                        roleData: this.roleSelectd,
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
                        adminData: this.form,
                        roleData: this.roleSelectd,
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
                });
            }

        },
        mounted(){
            self = this;
            resource = this.$resource('/admin/admins{/id}', {});
            this.initData();
            this.$http.get("/admin/permissions/list")
                    .then(function (response) {
                        console.log('permission' + response.data);
                        this.permissionData = response.data;
                    });
            this.$http.get("/admin/roles/list")
                    .then(function (response) {
                        console.log('role' + response.data);
                        this.roleData = response.data;
                    });
        }
    }


</script>