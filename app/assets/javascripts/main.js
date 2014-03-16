$(document).ready(function () {

	$('#userMessageModal').modal('show');

	$('#btn-login').click(function () {
		var email = $('#inputEmail').val();
		var password = $('#inputPassword').val();

		$.post('auth', { email: email, password: password },
			function (data) {
				$('#errorEmail').html(data['errors'][0]);
				$('#errorPassword').html(data['errors'][1]);
				if (data['authOk'] != null) {
					$('.navbar-right').html(data['authOk']);
					$('#loginModal').modal('hide');
				}
				if (data['authError'] != null) {
					$('#errorPassword').html(data['authError']);
				}
			}
		);

	});
});