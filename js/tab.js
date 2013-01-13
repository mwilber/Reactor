//Sample jquery ajax call
function DoAjax() {  
	
	$.get('ajaxresult.html', function(data) {

			$('#ajaxresult').html(data);
			SetFrame();
	});
}

// Post to user's wall using facebook javascript api
function WallPost(pLink, pTitle, pDescription, pImage, pCaption){
	FB.ui(
		{
			method: 'feed',
			name: pTitle,
			link: pLink,
			picture: pImage,
			caption: pCaption,
			description: pDescription,
			message: ''
		},
		function(response) {
			if (response && response.post_id) {
				alert('Post was published.');
			} else {
				alert('Post was not published.');
			}
		}
	);
}

// Post to user's wall using facebook javascript api
function RequestPost(pLink, pTitle, pDescription, pImage, pCaption, pMessage){
	FB.ui(
		{
			method: 'apprequests',
			to: '',
			message: pMessage
		},
		function(response) {
			if (response && response.request_ids) {
				alert('Post was published.');
			} else {
				alert('Post was not published.');
			}
		}
	);
}

// Post to user's wall using facebook javascript api
function SendPost(pLink, pTitle, pDescription, pImage, pCaption, pMessage){
	FB.ui(
		{
			method: 'send',
			name: pTitle,
			link: pLink,
			picture: pImage,
			caption: pCaption,
			description: pDescription,
			message: pMessage
		},
		function(response) {
			if (response) {
				alert('Post was published.');
			} else {
				alert('Post was not published.');
			}
		}
	);
}

// Get extended permissions and do something with it
function ExtendedPermissions() {
    FB.login(function(response) {
        if (response.session) {
        	// Now that we're logged in and authorized, let's make a graph call
        	FB.api('/me', function(response) {
        	    $("#ajaxresult").html("<strong>You -> </strong>" + response.name + " <img src='https://graph.facebook.com/" + response.id + "/picture'/>");
        	});
        } else {
            alert('Login Failed!');
        }
    }, {perms:'read_stream'});
}

// Resize the facebook iframe to match the height of the div #page
function SetFrame(){
	var docheight = $("#page").height();
	docheight = docheight+100;
	FB.Canvas.setSize({ width: 520, height: docheight });
}

$(document).ready(function() {
	FB.init({appId: facebookappid, cookie: true});

	// Get facebook session info
	FB.getLoginStatus(function(response) {
        if (response.session) {
        	//User has already authorized, you can skip the call to FB.login
        }
    });
});