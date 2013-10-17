<html>
<head>
	<title>test chrome paste image</title>
<style>
	DIV#editable {
		width: 400px;
		height: 300px;
		border: 1px dashed blue;
	}
</style>
<script type="text/javascript">

window.onload=function() {
	function paste_img(e) {
		if ( e.clipboardData.items ) {
		// google-chrome 
			alert('support clipboardData.items(may be chrome ...)');
			ele = e.clipboardData.items
			for (var i = 0; i < ele.length; ++i) {
				if ( ele[i].kind == 'file' && ele[i].type.indexOf('image/') !== -1 ) {
					var blob = ele[i].getAsFile();
					window.URL = window.URL || window.webkitURL;
					var blobUrl = window.URL.createObjectURL(blob);
					console.log(blobUrl);

                    /*
                    // show the img in browser instantly
					var new_img= document.createElement('img');
					new_img.setAttribute('src', blobUrl);
					var new_img_intro = document.createElement('p');
					new_img_intro.innerHTML = 'the pasted img url(open it in new tab): <br /><a target="_blank" href="' + blobUrl + '">' + blobUrl + '</a>';

					document.getElementById('editable').appendChild(new_img);
					document.getElementById('editable').appendChild(new_img_intro);
                    */

                    // upload the blob image
                    if ( !window.FormData ) {
                        alert('not support window.FormData may not upload file');
                    } else {
                        alert('support window.FormData');
                        var formData = new FormData();
                        formData.append('file', blob);

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', './receive_img.php', true);

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                console.log('upload success');
                                var server_img = document.createElement('img');
                                server_img.setAttribute('src', this.responseText);
                                document.getElementById('editable').appendChild(server_img);
                                console.log(this.responseText);

                            } else {
                                console.log('upload failed');
                            }
                        }

                        xhr.send(formData);
                    }

				}

			}
		} else {
			alert('non-chrome');
		}
	}
	document.getElementById('editable').onpaste=function(){paste_img(event);return false;};
}

</script>
</head>
<body >
	<h2>test image paste in browser</h2>
	<div id="non-editable" >
		<p>copy the following img, then paste it into the area below</p>
		<img src="./128.png" />
	</div>
	<div id="editable" contenteditable="true" >
		<p>this is an editable div area</p>
		<p>paste the image into here.</p>
	</div>
</body>
</html>
