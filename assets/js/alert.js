	function playSound(filename){
		var mp3Source = '<source src="assets/sounds/' + filename + '.mp3" type="audio/mpeg">';
        var oggSource = '<source src="assets/sounds/' + filename + '.ogg" type="audio/ogg">';
        var embedSource = '<embed hidden="true" autostart="true" loop="false" src="assets/sounds/' + filename +'.mp3">';
        document.getElementById("sound").innerHTML='<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
	}
