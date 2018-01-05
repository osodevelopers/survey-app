export default {
	setUser(context,user) {
		console.log('Set User Action !!!!!!!!!!!!!!!!!!!!!!');
    	context.commit('SET_USER',user);
    },
    setSurvey(context,data){
		console.log('Set Survey !!!!!!!!!!!!!!!!!!!!!!');
    	context.commit('SET_SURVEY',data);
    },
    setToken(context,data){
    	context.commit('SET_TOKEN',data);
    }
}