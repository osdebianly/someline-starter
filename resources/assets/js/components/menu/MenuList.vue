<template>
    <el-menu default-active="1" theme="dark" class="el-menu-vertical-demo" @select="handleSelect">
        <div v-for="(menu,index) in menus">

            <el-submenu v-if="isMenuGroup(menu)" :index="toString(index)">
                <template slot="title"><i class="el-icon-menu"></i>{{ menu.name }}</template>
                <el-menu-item v-for="childMenu in menu.children" :index="childMenu.id">
                    {{ childMenu.name }}
                </el-menu-item>
            </el-submenu>

            <el-menu-item v-else :index="menu.id"><i class="el-icon-menu"></i>{{ menu.name }}</el-menu-item>
        </div>
    </el-menu>

</template>
<style>

</style>
<script>

    export default{
        data(){
            return{
                menus:[
                    {
                        "id":"1",
                        "name":"菜单1",
                        "url":"/admin",
                        "children":[
                            {
                                "id":"2",
                                "name":"1-1",
                                "url":"/admin"
                            },
                            {
                                "id":"3",
                                "name":"1-2",
                                "url":"/admin/2"
                            }
                        ]
                    },
                    {
                        "id":"4",
                        "name":"菜单2",
                        "url":"/admin"

                    },
                     {
                        "id":"5",
                        "name":"菜单3",
                        "url":"/admin"

                    }
                ]
            }
        },
        computed: {
            allMenus:function(){
                 var tmpMenus = [] ;
                 var self = this ;
                 this.menus.forEach(function(menu){
                     if(self.isMenuGroup(menu)){
                          menu.children.forEach(function(childMenu){
                                tmpMenus.push(childMenu);
                          });
                     }else{
                            tmpMenus.push(menu);
                     }
                 }) ;
                 return tmpMenus ;
            }

        },
        methods: {
              handleSelect(key,keyPath){
      	            console.log("select menu id "+key);

                    var selectMenu = this.allMenus.find(function(menu){
                        return menu.id == key ;
                    }) ;
                    console.log('redirect:'+selectMenu.url) ;
      	            this.redirectToUrlFromBaseUrl(selectMenu.url);
              },
              isMenuGroup: function (menu) {
                return  menu.children && menu.children.length
            }

        },
        mounted(){
            console.log('Component ready') ;
        }

    }



</script>
