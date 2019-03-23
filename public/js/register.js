$(document).ready(function(){
	$('.datepicker').datepicker({
		maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 18)),
		onSelect: function(date){
			app.form.date = toJSONLocalDate(new Date(date));
		},
		format: 'yyyy-mm-dd'
	});
});

function toJSONLocalDate(date){
	let local = new Date(date);
	local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
	return local.toJSON().slice(0, 10);
}


var app = new Vue({
  el: '#app',
  data: {
	form: {
		name: '',
		email: '',
		date: '',
		phone: '',
	}
  },
  methods: {
	submit: function(event) {
		event.preventDefault();
		
		$.ajax({
			method: 'POST',
			url: '/auth/register',
			data: this.form,
			success: function(r){
				alert('Успешно');
				window.location.replace('/auth/login');
			},
			error: function(r){
				alert('Ошибка');
			}
		});

	}
  }
});