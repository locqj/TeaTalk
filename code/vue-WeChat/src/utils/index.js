var utils = {
    a: 'hello',
    b: function(){
        console.log("hello");
    },
    getLocation: function(){
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){
        	if(this.getStatus() == BMAP_STATUS_SUCCESS){
                // return r.point.lng
        		console.log('您的位置：'+r.point.lng+','+r.point.lat);
        	}
        });
    }
}
export default utils
