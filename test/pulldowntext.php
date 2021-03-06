<html>
<head>
	<style type="text/css">
	
body{background-color:grey}

@charset 'UTF-8';
#cssmenu ul,
#cssmenu li,
#cssmenu span,
#cssmenu a {
  border: 0;
  margin: 0;
  padding: 0;
  position: relative;
}
#cssmenu {
  font-weight: 600;
  height: 30px;
  width: 192px;
  float:right;
  margin: 9px 5px 0 0;
}
#cssmenu:after,
#cssmenu ul:after {
  content: '';
  display: block;
  clear: both;
}
#cssmenu a {
  box-shadow: inset 0 1px 0 whitesmoke;
  -moz-box-shadow: inset 0 1px 0 whitesmoke;
  -webkit-box-shadow: inset 0 1px 0 whitesmoke;
  background: #f2edea url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAA0CAIAAADEwMXAAAAAA3NCSVQICAjb4U/gAAAAMklEQVQImWP49PYV0////6GYAcFm+I9d/P9/JgZkcRR12NVDzMMihlMtRJyBkHpMNwIA6ZmLp7k56KwAAAAASUVORK5CYII=) 100% 100%;
  background: -moz-linear-gradient(top, #f2edea 0%, #c0bebf 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f2edea), color-stop(100%, #c0bebf));
  background: -webkit-linear-gradient(top, #f2edea 0%, #c0bebf 100%);
  background: -o-linear-gradient(top, #f2edea 0%, #c0bebf 100%);
  background: -ms-linear-gradient(top, #f2edea 0%, #c0bebf 100%);
  background: linear-gradient(to bottom, #f2edea 0%, #c0bebf 100%);
  color: #666666;
  display: inline-block;
  font-family: Arial, Verdana, sans-serif;
  font-size: 12px;
  line-height: 30px;
  padding: 0 28px;
  text-decoration: none;
}
#cssmenu ul {
  list-style: none;
 
}
#cssmenu > ul {
  float: left;

}
#cssmenu > ul > li {
  float: left;
}
#cssmenu > ul > li:first-child a {
  border-radius: 5px 5px 5px 5px;
  -moz-border-radius: 5px 5px 5px 5px;
  -webkit-border-radius: 5px 5px 5px 5px;
}
/*#cssmenu > ul > li.active a,*/
#cssmenu > ul > li:hover > a {
  box-shadow: inset 0 -2px 3px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: inset 0 -2px 3px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: inset 0 -2px 3px rgba(0, 0, 0, 0.15);
  color: white;
      border-radius: 5px 5px 5px 5px;
  -moz-border-radius: 5px 5px 5px 5px;
  -webkit-border-radius: 5px 5px 5px 5px;
  background: #456585 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAA0CAIAAADEwMXAAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkNDNkM2QzM1NDk0QjExRTI5NjFDQzlFM0NGQzY5RDNBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkNDNkM2QzM2NDk0QjExRTI5NjFDQzlFM0NGQzY5RDNBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6Q0M2QzZDMzM0OTRCMTFFMjk2MUNDOUUzQ0ZDNjlEM0EiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6Q0M2QzZDMzQ0OTRCMTFFMjk2MUNDOUUzQ0ZDNjlEM0EiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6bEPV5AAAAUUlEQVR42mSO0RWAMAgDc4znAA7g/jvUFKj66gevCT0COs4rJLkIoSC1X+j+7GFfupj+a4bFu+isydcMr88dY/PkLL8bPnrLXTvHk2NdzC3AAIj5BKfn0x2aAAAAAElFTkSuQmCC);
  background: -moz-linear-gradient(top, #456585 0%, #567ea7 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #456585), color-stop(100%, #567ea7));
  background: -webkit-linear-gradient(top, #456585 0%, #567ea7 100%);
  background: -o-linear-gradient(top, #456585 0%, #567ea7 100%);
  background: -ms-linear-gradient(top, #456585 0%, #567ea7 100%);
  background: linear-gradient(to bottom, #456585 0%, #567ea7 100%);
}
#cssmenu .has-sub {
  z-index: 1;
}
#cssmenu .has-sub:hover > ul {
  display: block;
}
#cssmenu .has-sub ul {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
  display: none;
  position: absolute;
  width: 200px;
  top: 100%;
  left: 0;
}
#cssmenu .has-sub ul li a {
  background: #567ea7;
  border-bottom: 1px solid #59636f;
  border-bottom: 1px solid #4e7296;
  box-shadow: inset 0 1px 0 #567ea7;
  -moz-box-shadow: inset 0 1px 0 #567ea7;
  -webkit-box-shadow: inset 0 1px 0 #567ea7;
  color: white;
  display: block;
  line-height: 160%;
  padding: 5px 10px;
  font-size: 12px;
  width:162px;
  margin:1px;
}
#cssmenu .has-sub ul li:hover a {
  background: #456585;
  box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
}
#cssmenu .has-sub .has-sub:hover > ul {
  display: block;
}
#cssmenu .has-sub .has-sub ul {
  display: none;
  position: absolute;
  left: 100%;
  top: 0;
}
#cssmenu .has-sub .has-sub ul li a {
  background: #567ea7;
  box-shadow: none;
  -moz-box-shadow: none;
  -webkit-box-shadow: none;
}
#cssmenu .has-sub .has-sub ul li a:hover {
  background: #456585;
  box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, 0.15);
}
		

	</style>
</head>
<body>
<div id='cssmenu'>
	<ul>
		<li class="active has-sub"><a href="#">Menu</a>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="csvoutput.php">Excel Report</a></li>
				<li><a href="monthlysummaryscreen.php">On Screen Report</a></li>
				<li><a href="delete-voucher.php">Delete Voucher</a></li>
			</ul>
		</li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</div>
</body>
</html>