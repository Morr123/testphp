var app = new Vue({
  el: '#app',
  data: {
	form: {
		name: '',
		email: '',
	}
  },
  methods: {
	submit: function(event) {
		event.preventDefault();
		
		$.ajax({
			method: 'POST',
			url: '/auth/login',
			data: this.form,
			success: function(r){
				alert('Успешно');
				window.location.replace('/');
			},
			error: function(r){
				alert('Ошибка');
			}
		});

	}
  }
});