$(function() {
	$('[data-decrease]').click(decrease);
	$('[data-increase]').click(increase);
	$('[data-value]').change(valueChange);
});

function decrease() {
	var value = $(this).parent().find('[data-value]').val();
	if(value >= 1) {
		value--;
		$(this).parent().find('[data-value]').val(value);
	}
}

function increase() {
	var value = $(this).parent().find('[data-value]').val();
	if(value < 100) {
		value++;
		$(this).parent().find('[data-value]').val(value);
	}
}

function valueChange() {
	var value = $(this).val();
	if(value == undefined || isNaN(value) == true || value <= 0) {
		$(this).val(1);
	} else if(value >= 101) {
		$(this).val(100);
	}
}






var data3 = 0;
var data4 = 0;
document.getElementById("root3").innerText = data3;
document.getElementById("root4").innerText = data4;

function decrement3() {
    data3 = 0 <= data3 - 1 ? data3 - 1 : 0;
    document.getElementById("root3").innerText = data3;
}

function increment3() {
    data3 = 12 >= data3 + 1 ? data3 + 1 : 12;
    document.getElementById("root3").innerText = data3;
}


function increment4() {
    data4 = 31 >= data4 + 1 ? data4 + 1 : 31;
    document.getElementById("root4").innerText = data4;
}

function decrement4() {
    data4 = 0 <= data4 - 1 ? data4 - 1 : 0;
    document.getElementById("root4").innerText = data4;
}
