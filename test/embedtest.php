<!-- Test to embed PHP Calendar in div on page-->
<html>
<body>
<head>
<title>My Test Embedded Calendar</title>

<style type="text/css">
.floatleft{
float:left;
}

.floatright{
float:right;
}

.center{
text-align:center;
margin: 0 auto;
}

.padding15{
padding:0 15px;
}

.width300{
width:300px;
}

.width500{
width:500px;
}

.width40percent{
width:40%;
min-width:500px;
}

.height500{
min-height:500px;
}

.clearfloat{
clear:both;
}

.backgroundblue{
background-color:rgb(199,236,252);
}

.backgroundgreen{
background-color:rgb(198,255,237);
}
</style>

</head>

<body>
	<div id="wrapper">
		<header id="pageheader">
			<h1 class="center">My Page Header</h1>
		</header>

		<div id="leftsidebar" class="floatleft width300 height500 backgroundblue padding15">
			<h1 class="center">My Left Sidebar Title</h1>
			<p>My left sidebar text goes here.</p>
		</div>

		<div id="maincontent" class="floatleft height500 width40percent backgroundgreen padding15">
			<h1 class="center">My Main Content Title</h1>
			<p>My main content text goes here.</p>
		</div>

		<div id="calendarholder" class="floatright width500 backgroundblue height500 padding15">
			<iframe class="width500 height500" frameborder="0" src="http://bi.com/dev/php-calendar/index.php"></iframe>
		</div>
		
		<footer id="pagefooter">
			<h2 class="center clearfloat">My Page Footer</h2>
		</footer>
	</div>

</body>
</html>