<template>
	<el-container>
	    <el-header style="text-align: right; font-size: 12px">
	    	<img class="logo pull-left" src="/logo.png">
	      <el-dropdown>
	        <i class="el-icon-setting" style="margin-right: 15px"></i>
	        <el-dropdown-menu slot="dropdown">
	          <!-- <el-dropdown-item><div @click="hello">View</div></el-dropdown-item>
	          <el-dropdown-item>Add</el-dropdown-item> -->
	          <el-dropdown-item><div @click="logoutF">Logout</div></el-dropdown-item>
	        </el-dropdown-menu>
	      </el-dropdown>
	      <span>{{name}}</span>
	    </el-header>
	        
		<el-container>
		    <el-aside>
		      <el-menu :default-openeds="['1', '3']">
		      	<router-link to="/dashboard/survey" exact>
			      	<el-menu-item index="2">
					    <i class="el-icon-menu"></i>
					    <span>Dashboard</span>
				    </el-menu-item>
			    </router-link>
		        <el-submenu index="1">
		          <template slot="title"><i class="el-icon-message"></i><router-link to="/dashboard/survey">Survey</router-link></template>
		          <el-menu-item-group>
		            <template slot="title">Surveys Management</template>
		            <router-link to="/dashboard/survey" exact>
		            	<el-menu-item index="1-1">Surveys
		            	</el-menu-item>
	            	</router-link>
		            <router-link to="/dashboard/create-survey" exact>
			            <el-menu-item index="1-1">Create Survey</el-menu-item>
		            </router-link>
		            <!-- <el-menu-item index="1-2"><router-link to="/bar">Go to Bar</router-link></el-menu-item> -->
		          </el-menu-item-group>
		          <!-- <el-menu-item-group title="Group 2">
		            <el-menu-item index="1-3" @click="hello">Option 3</el-menu-item>
		          </el-menu-item-group>
		          <el-submenu index="1-4">
		            <template slot="title">Option4</template>
		            <el-menu-item index="1-4-1">Option 4-1</el-menu-item>
		          </el-submenu> -->
		        </el-submenu>
		       <!--  <el-submenu index="2">
		          <template slot="title"><i class="el-icon-menu"></i>Navigator Two</template>
		          <el-menu-item-group>
		            <template slot="title">Group 1</template>
		            <el-menu-item index="2-1">Option 1</el-menu-item>
		            <el-menu-item index="2-2">Option 2</el-menu-item>
		          </el-menu-item-group>
		          <el-menu-item-group title="Group 2">
		            <el-menu-item index="2-3">Option 3</el-menu-item>
		          </el-menu-item-group>
		          <el-submenu index="2-4">
		            <template slot="title">Option 4</template>
		            <el-menu-item index="2-4-1">Option 4-1</el-menu-item>
		          </el-submenu>
		        </el-submenu>
		        <el-submenu index="3">
		          <template slot="title"><i class="el-icon-setting"></i>Navigator Three</template>
		          <el-menu-item-group>
		            <template slot="title">Group 1</template>
		            <el-menu-item index="3-1">Option 1</el-menu-item>
		            <el-menu-item index="3-2">Option 2</el-menu-item>
		          </el-menu-item-group>
		          <el-menu-item-group title="Group 2">
		            <el-menu-item index="3-3">Option 3</el-menu-item>
		          </el-menu-item-group>
		          <el-submenu index="3-4">
		            <template slot="title" >Logout</template>
		            <el-menu-item index="3-4-1" @click="logoutF">Option 4-1</el-menu-item>
		          </el-submenu>
		        </el-submenu> -->
		      </el-menu>
		    </el-aside>
		    
		    <el-main style="background-color: #ECECEC;">
		      <router-view></router-view>
		    </el-main>
		</el-container>
		<el-footer>
			<el-row :gutter="20" justify="center" align="middle" style="text-align: center">
				© OSO oso.nyc
			</el-row>
		</el-footer>
	</el-container>	
</template>
<style>
  .logo{
  	height: 60px;
  	width: auto;
  }
  .el-header {
    background-color: #B3C0D1;
    /*background-color: #3097D1;*/
    color: #333;
    line-height: 60px;
  }
  .el-aside {
  	background-color: #d7e0e4;
    color: #333;
    height: 95vh;
  }
  .router-link-exact-active .router-link-active{
  	background-color: #3097D1;
  }.el-footer{
  	background-color: #B3C0D1;
    color: #333;
    line-height: 50px;
  }
</style>

<script>
  export default {
  	mounted() {
	      	this.name = this.$store.state.user.data.name;
	  },
    data() {
      return {
        name : 'Tom'
      }
    },
    methods: {
	    logoutF() {
    		console.log('LogOUT!!!!!!!!!!!!!!');
    		this.$store.commit('SET_USER', null);
    		this.$store.commit('SET_TOKEN', null);
    		if (window.localStorage) {
    		  window.localStorage.setItem('user', null);
    		  window.localStorage.setItem('token', null)
    		}
    		this.$router.push('/login');
    	},
	  }
  };
</script>