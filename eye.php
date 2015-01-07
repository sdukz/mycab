<html>
<head>
   


    <style type="text/css">
        input.pwdTxt[type=text], input.pwdTxt[type=password], .pwdTxt
        {
        	font-size: 12px;
        	width: 160px;
        	padding: 2px;
        	margin: 2px;
        	vertical-align: middle;
        	font-family: sans-serif;
        }
    </style>

</head>
<body>
	<form>
		 <input id="password" class="pwdTxt" 
                    type="password" maxlength="40" />
	</form>
    
    <div style="line-height: 23px">
        <label for="password">Password </label>
       
    </div>
 <script type="text/javascript">
        var utils = {
            findPos: function (obj) {
                var curleft = curtop = 0;
                if (obj.offsetParent) {
                    do {
                        curleft += obj.offsetLeft;
                        curtop += obj.offsetTop;
                    } while (obj = obj.offsetParent);
                }
                return [curleft, curtop];
            },
            pwdEye: function (id, w, h, marginRight) {
                // Detect IE version
                var ie = (function () {
                    var undef, v = 3, div = document.createElement('div');

                    while (
                        div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
                        div.getElementsByTagName('i')[0]
                    );
                    return v > 4 ? v : undef;
                } ());

                // Check password element
                var pwdTxt = document.getElementById(id);
                if (!pwdTxt) {
                    return;
                }

                // Right edge
                if (!marginRight) {
                    marginRight = 0;
                }

                // Get width and height of password text box to insert eye icon
                var width = pwdTxt.clientWidth;
                var height = pwdTxt.clientHeight;

                if (width == 0 && height == 0) { // For old IE
                    width = pwdTxt.offsetWidth;
                    height = pwdTxt.offsetHeight;
                }

                // Get position of password text box
                var pos = utils.findPos(pwdTxt);

                // Create eye icon
                var img = document.createElement("IMG");
                // So sorry iconfinder
                img.src = 'http://cdn1.iconfinder.com/data/icons/windows8_icons_iconpharm/26/visible.png';
                img.style.left = (pos[0] + width - w - marginRight) + 'px';
                img.style.top = (pos[1] + (height - h) / 2 + 1) + 'px';
                img.style.position = 'absolute';
                img.style.cursor = 'pointer';
                img.style.width = w + 'px';
                img.style.height = h + 'px';
                img.style.display = 'none';

                // Handle visible status of eye icon
                pwdTxt.onkeyup = function () {
                    if (this.value != '') {
                        img.style.display = 'block';
                    }
                    else {
                        img.style.display = 'none';
                        if (ie >= 10) {
                            this.setAttribute("type", "password");
                        }
                    }
                }

                // For some old IE version, we need to create a mask text box
                var pwdTxtMask = null;
                if (ie < 10) { // Need to create a mask text box
                    pwdTxtMask = document.createElement("INPUT");
                    pwdTxtMask.setAttribute("type", "text");

                    pwdTxtMask.maxLength = pwdTxt.maxLength;
                    pwdTxtMask.style.display = 'none';
                    pwdTxtMask.className = pwdTxt.className;

                    // Append mask text box
                    pwdTxt.parentNode.insertBefore(pwdTxtMask, pwdTxt);

                    // Auto-copy value from password text box
                    pwdTxt.onchange = function (e) {
                        pwdTxtMask.value = this.value;
                    }
                }

                // Append eye icon
                pwdTxt.parentNode.appendChild(img);

                // Handle event
                img.onmousedown = img.ontouchstart = function (event) {
                    if (ie < 10) {
                        pwdTxt.style.display = 'none';
                        pwdTxtMask.style.display = 'inline';
                    }
                    else {
                        pwdTxt.setAttribute("type", "text");
                    }
                    return utils.absorbEvent(event);
                }
                img.onmouseup = img.onmouseout = img.ontouchend = function (event) {
                    if (ie < 10) {
                        pwdTxt.style.display = 'inline';
                        pwdTxtMask.style.display = 'none';
                    }
                    else {
                        pwdTxt.setAttribute("type", "password");
                    }
                    return utils.absorbEvent(event);
                }

                return img;
            },
            absorbEvent: function (event) {
                var e = event || window.event;
                e.preventDefault && e.preventDefault();
                e.stopPropagation && e.stopPropagation();
                e.cancelBubble = true;
                e.returnValue = false;
                return false;
            }
        }

        // Apply password eye for element with id 'password'
        utils.pwdEye('password', 20, 20, 1);
    </script>
   
</body>
</html>