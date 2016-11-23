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
            <el-col :span="3" :offset="9">
                <el-button icon="plus" type="success" @click="handleAdd">新增</el-button>
            </el-col>
        </el-row>


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
                    label="PID"
                    prop="pid"
                    width="100"
                    sortable>
            </el-table-column>
            <el-table-column
                    label="菜单名"
                    prop="name">
            </el-table-column>
            <el-table-column
                    label="菜单权限"
                    prop="slug"
                    sortable>
            </el-table-column>
            <el-table-column
                    label="菜单链接"
                    prop="url">
            </el-table-column>
            <el-table-column
                    label="描述"
                    prop="description">
            </el-table-column>
            <el-table-column
                    label="排序"
                    prop="sort">
            </el-table-column>
            <el-table-column
                    inline-template
                    label="更新时间">
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
                <el-form-item label="父ID" :label-width="formLabelWidth">
                    <el-input v-model="form.fid" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="菜单名" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="链接" :label-width="formLabelWidth">
                    <el-input v-model="form.url" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="描述" :label-width="formLabelWidth">
                    <el-input v-model="form.description" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="排序" :label-width="formLabelWidth">
                    <el-input v-model="form.sort" auto-complete="off"></el-input>
                </el-form-item>
                <el-row>
                    <el-col :span="10" :offset="4">
                        <el-select v-model="permissionSelectd" placeholder="请选择权限" :label-width="formLabelWidth">
                            <el-option
                                    v-for="item in permissionData"
                                    :label="item"
                                    :value="item">
                            </el-option>
                        </el-select>
                    </el-col>
                </el-row>

            </el-form>

            <br/>

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
    var list = [];

    export default {
        data() {
            return {
                tableData: [],
                permissionData: [],
                permissionSelectd: [],
                dialogFormVisible: false,
                form: {},
                formLabelWidth: '120px',
                loading: true,
                search: ''
            }
        },
        watch: {
            search: function (val, oldVal) {
                console.log('new: %s, old: %s', val, oldVal);
                var result = [];
                list.forEach(function (row) {
                    var name = row.name;
                    var url = row.url;
                    var slug = row.slug;
                    if (name.indexOf(val) != -1 || url.indexOf(val) != -1 || slug.indexOf(val) != -1) {
//                        console.log('find'+row) ;
                        result.push(row);
                    }
                });
                this.tableData = result;
            }
        },
        methods: {
            handleEdit(index, row) {
                //console.log(index, row);
                this.form = row;
                this.$http.get("/admin/menus/" + row.id + "/permission")
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
                        menuData: this.form,
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
                        menuData: this.form,
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
                    list = response.data;
                    this.loading = false;
                });
            }

        },
        mounted(){
            self = this;
            resource = this.$resource('/admin/menus{/id}', {});
            this.initData();
            this.$http.get("/admin/permissions/list")
                    .then(function (response) {
                        console.log('permission' + response.data);
                        this.permissionData = response.data;
                    });
        }
    }


</script>