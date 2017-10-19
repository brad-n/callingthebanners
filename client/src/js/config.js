/**
 * Base config object
 */

(function () {
  'use strict';
  if (!window.cfg) {
    window.cfg = {
      hostAndPort: function () {
        return '//' + window.location.host;
      }
      ,host: function () {
        return 'http://' + window.location.host.replace(/:[0-9]+$/, '');
      }
	  ,apiBaseUrl_set:''
	  ,apiBaseUrl: function(){
			if(this.apiBaseUrl_set) return this.apiBaseUrl_set;

			if( this.hostAndPort().match(/callingthebanners.com/) ){
				this.server='//app.callingthebanners.com';
				this.basehref="/";
			}else if (this.host().match(/(192.)/)){
				//192.168.1.203:8888/callingthebanners/client/src/
				console.log(this.hostAndPort());
				this.server=this.hostAndPort()+"/callingthebaners/server/";
				this.basehref="/callingthebanners/client/";
			}else if( this.hostAndPort().match(/:8888/) || this.host().match(/(localh|127.0.0|0.0.0)/)) {
                this.server='//localhost:8888/callingthebanners/server/';
                this.basehref="/callingthebanners/client/";
			}

			this.apiBaseUrl_set = this.server;
			return this.apiBaseUrl_set;
	  }
	 
    };
  }


})();


