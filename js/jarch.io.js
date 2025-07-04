Number.prototype.format = function(money, round) {
	var money = money !== undefined ? money : true;
	var round = round !== undefined ? round : true;
	var sm = ',';
	var sd = '.';
	var number = (isNaN(this) ? 0 : this);
	var str = (round ? number.toFixed(2) : number) + "";
	var sn = str.split(sd);
	sleft = sn[0];
	sright = sn.length > 1 ? (sd + (sn[1].length == 2 ? sn[1] : (sn[1].length == 1 ? sn[1] + '0' : sn[1].substring(0, 2)))) : (sd + '00');

	if(money === true){
		var rgx = /(\d+)(\d{3})/;

		while(rgx.test(sleft)) {
			sleft = sleft.replace(rgx, '$1' + sm + '$2');
		}
	}

	return sleft + sright;
};
