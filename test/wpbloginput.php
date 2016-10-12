<!--load jQuery-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	//on print button click, fetch blog title and content
	//and make AJAX call to PDF writer PHP file (wpblogpdfoutput.php)
	$('#btnprint').click(function()
	{
		//check if printing page or post
		//post - check for body class single-post
		//fetch post title, content and generate PDF
		if($('body').hasClass('single-post'))
		{
			//fetch blog id
			//split body element classes into array
			str = $('body').attr('class');
			var myclasses = str.split(" ");
			for (var i=0;i<myclasses.length;i++)
			{
				var myclass = myclasses[i].substring(0,7);
				if(myclass=='postid-')
				{
					var myid = myclasses[i].substring(7,13);
					alert(myid);
				}
			}
			
			//fetch blog title
			var myblogtitle = $('.page-introduce-title').html();
			//fetch blog content
			var myblogcontent = $('.mk-single-content').html();
			//make AJAX call to PDF writer
			$.ajax({
				type:"POST",
				url:'wpblogpdfoutput.php',
				data:{postid: myid,posttitle:myblogtitle,posttext:myblogcontent},
				success:function(data){
					alert(data);
					var mypdfurl = "pdf/" + data + '.pdf';
					//alert(mypdfurl);
					window.open(mypdfurl,"pdf");
				}
			})
			.done(function(){
				alert("PDF successfully generated");
			});
		}//end body class single-post
		else
		{ //not a post - open PDF
			//fetch id of print class element to get name of PDF to open
			var myid = $(".print").attr("id");
			//alert(myid);
			//build path to PDF
			var mypath = "http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/pdfs/screenprints/" + myid + '.pdf';
			//alert(mypath);
			//open PDF in native app
			window.open(mypath);
		
		}
	});

});

</script>

<html>
<body class="single  single-post postid-10157 single-format-standard logged-in admin-bar main-nav-align-left customize-support mk-transform mk-desktop">
<div class="print" id="homepage"></div>
<button id="btnprint">Print</button>
<h1 class="page-introduce-title mk-drop-shadow">BI Incorporated GPS tracking devices helping to monitor sex offenders in Arizona</h1>

<div class="mk-single-content">
	<p><a href="http://bi.com/wp-content/uploads/2014/11/ETOne_White-compressed.jpg"><img width="226" height="184" alt="BI ExacuTrack One" src="http://bi.com/wp-content/uploads/2014/11/ETOne_White-compressed-300x244.jpg" class="alignright  wp-image-1962"></a>Technology provided by BI Incorporated is <a href="http://dcourier.com/main.asp?SectionID=1&amp;SubSectionID=1&amp;ArticleID=138356">helping officials in northern Arizona</a> keep track of probationers convicted of sex crimes, as well as anyone else ordered to be tracked by the court.</p>
	<p>The probationers are tracked by two men who work for the Yavapai County Adult Probation Office who are in charge of monitoring seven counties in northern Arizona in all. As The Daily Courier notes, each GPS ankle bracelet sends a signal to a satellite geosynchronous Earth orbit and that information is then fed to computers that store each probationer's movement parameters.</p>
	<p>The officers monitor these movements by tracking them on a computer map display that is programmed to know where sex offenders are prohibited from being near, like schools and parks. Once an offender moves into an unauthorized area, their movements appear as red on the map display and the officers receive an alert.</p>
	<p>Though the officers monitor seven days a week, BI supports the probation office when officers are off-duty.</p>
	<p>The analysts said the probationers know they are being watched, so most of the alerts are for the wearer failing to charge the bracelet. If a wearer attempts to disconnect the bracelet, an alert is sent to their probation officer, who is in charge of sanctioning the offender for violations.</p>
	<p>BI Incorporated provides electronic monitoring technology to correctional agencies across the country. One of the most popular devices is the <a href="http://bi.com/exacutrackone">BI ExacuTrack&reg; One</a>, a one-piece, ankle-mounted tracking unit that relies on GPS tracking data and other location monitoring technologies to accurately track an offender’s movement within local communities.</p>
	<p>For more information about our technology, click <a href="http://bi.com/products-gallery">here</a>.</p>
	<p>The probationers are tracked by two men who work for the Yavapai County Adult Probation Office who are in charge of monitoring seven counties in northern Arizona in all. As The Daily Courier notes, each GPS ankle bracelet sends a signal to a satellite geosynchronous Earth orbit and that information is then fed to computers that store each probationer’s movement parameters.</p>
	<p>The officers monitor these movements by tracking them on a computer map display that is programmed to know where sex offenders are prohibited from being near, like schools and parks. Once an offender moves into an unauthorized area, their movements appear as red on the map display and the officers receive an alert.</p>
	<p>Though the officers monitor seven days a week, BI supports the probation office when officers are off-duty.</p>
	<p>The analysts said the probationers know they are being watched, so most of the alerts are for the wearer failing to charge the bracelet. If a wearer attempts to disconnect the bracelet, an alert is sent to their probation officer, who is in charge of sanctioning the offender for violations.</p>
	<p>BI Incorporated provides electronic monitoring technology to correctional agencies across the country. One of the most popular devices is the <a href="http://bi.com/exacutrackone">BI ExacuTrack&reg; One</a>, a one-piece, ankle-mounted tracking unit that relies on GPS tracking data and other location monitoring technologies to accurately track an offender’s movement within local communities.</p>
	<p>For more information about our technology, click <a href="http://bi.com/products-gallery">here</a>.</p>
	<p>The probationers are tracked by two men who work for the Yavapai County Adult Probation Office who are in charge of monitoring seven counties in northern Arizona in all. As The Daily Courier notes, each GPS ankle bracelet sends a signal to a satellite geosynchronous Earth orbit and that information is then fed to computers that store each probationer’s movement parameters.</p>
	<p>The officers monitor these movements by tracking them on a computer map display that is programmed to know where sex offenders are prohibited from being near, like schools and parks. Once an offender moves into an unauthorized area, their movements appear as red on the map display and the officers receive an alert.</p>
	<p>Though the officers monitor seven days a week, BI supports the probation office when officers are off-duty.</p>
	<p>The analysts said the probationers know they are being watched, so most of the alerts are for the wearer failing to charge the bracelet. If a wearer attempts to disconnect the bracelet, an alert is sent to their probation officer, who is in charge of sanctioning the offender for violations.</p>
	<p>BI Incorporated provides electronic monitoring technology to correctional agencies across the country. One of the most popular devices is the <a href="http://bi.com/exacutrackone">BI ExacuTrack&reg; One</a>, a one-piece, ankle-mounted tracking unit that relies on GPS tracking data and other location monitoring technologies to accurately track an offender’s movement within local communities.</p>
	<p>For more information about our technology, click <a href="http://bi.com/products-gallery">here</a>.</p>
	<p>The probationers are tracked by two men who work for the Yavapai County Adult Probation Office who are in charge of monitoring seven counties in northern Arizona in all. As The Daily Courier notes, each GPS ankle bracelet sends a signal to a satellite geosynchronous Earth orbit and that information is then fed to computers that store each probationer’s movement parameters.</p>
	<p>The officers monitor these movements by tracking them on a computer map display that is programmed to know where sex offenders are prohibited from being near, like schools and parks. Once an offender moves into an unauthorized area, their movements appear as red on the map display and the officers receive an alert.</p>
	<p>Though the officers monitor seven days a week, BI supports the probation office when officers are off-duty.</p>
	<p>The analysts said the probationers know they are being watched, so most of the alerts are for the wearer failing to charge the bracelet. If a wearer attempts to disconnect the bracelet, an alert is sent to their probation officer, who is in charge of sanctioning the offender for violations.</p>
	<p>BI Incorporated provides electronic monitoring technology to correctional agencies across the country. One of the most popular devices is the <a href="http://bi.com/exacutrackone">BI ExacuTrack&reg; One</a>, a one-piece, ankle-mounted tracking unit that relies on GPS tracking data and other location monitoring technologies to accurately track an offender’s movement within local communities.</p>
	<p>For more information about our technology, click <a href="http://bi.com/products-gallery">here</a>.</p>
</div>
</body>
</html>
							
