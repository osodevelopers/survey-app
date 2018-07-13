export default {
    // Set User 
    setUser(context,user) {
        context.commit('SET_USER',user);
    },
    // Set User Role
	setRole(context,role) {
    	context.commit('SET_ROLE',role);
    },
    // Set Survey
    setSurvey(context,data){
    	context.commit('SET_SURVEY',data);
    },
    // Set Access Token
    setToken(context,data){
    	context.commit('SET_TOKEN',data);
    }
}