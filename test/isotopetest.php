<?php
//fetch GET variable - category
if (isset($_GET['cat']))
{
	$myCat = ($_GET['cat']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/isotope.pkdg.2.0.0.min.js"></script>

<script>
jQuery(document).ready(function($)
{
	var $container = $('.mk-portfolio-container').isotope({
	//options
		itemSelector: '.mk-portfolio-item',
		/*getSortData:{
			name: '.name',
			category: '[data-category]'
		},*/
		//layout mode options
		masonry:{
			columnWidth:200
		}
	});

	$container.isotope({filter: '<?php echo $myCat?>'});

	$("#btnall").click(function(){
		$container.isotope({filter:'*'});
	});

	$("#btngps").click(function(){
		$container.isotope({filter:'.gps-tracking-portfolio'});
	});
	
	$("#btnalcohol").click(function(){
		$container.isotope({filter:'.alcohol-monitoring-portfolio'});
	});

	
});
</script>

<style>
.item{width:25%;}

#container{
overflow:visible !important
}

</style>

<body>
<button id="btnall">All Products</button>
<button id="btngps">GPS</button>
<button id="btnalcohol">Electronic Monitoring</button>
<div id="container" class="mk-portfolio-container">
  <!--<article class="mk-isotope-item transition metal">1</article>
  <article class="mk-isotope-item post-transition metal">2</article>
  <article class="mk-isotope-item alkali metal">3</article>
  <article class="mk-isotope-item transition metal">4</article>
  <article class="mk-isotope-item lanthanoid metal inner-transition">5</article> 
  <article class="mk-isotope-item halogen nonmetal">6</article> 
  <article class="mk-isotope-item alkaline-earth metal">7</article>-->
  
  <article id="801" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image gps-tracking-portfolio"><div class="portfolio-classic-holder"><div class="featured-image"><img alt="Exacutrack" title="Exacutrack" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_et-2x03g2drqrb7e6dm14p2bk.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/gps/exacutrack/"><i class="mk-icon-link"></i></a><a data-title="Exacutrack" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_et.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/gps/exacutrack/">Exacutrack</a></h3><div class="clearboth"></div><div class="portfolio-categories"><a href="http://bidotcomnew.bi.com/bidotcomnew/?portfolio_category=gps-tracking-portfolio">GPS Monitoring Portfolio</a> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="807" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="Drive-BI" title="Drive-BI" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_drivebi-2x03g4w8klyyz5b1qge6f4.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/drive-bi/"><i class="mk-icon-link"></i></a><a data-title="Drive-BI" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_drivebi.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/drive-bi/">Drive-BI</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="812" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image gps-tracking-portfolio"><div class="portfolio-classic-holder"><div class="featured-image"><img alt="ExacuTrack One" title="ExacuTrack One" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_et1-2x03fu387g4ryz42lyhse8.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/gps/exacutrack-one/"><i class="mk-icon-link"></i></a><a data-title="ExacuTrack One" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/05/port_et1.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/gps/exacutrack-one/">ExacuTrack One</a></h3><div class="clearboth"></div><div class="portfolio-categories"><a href="http://bidotcomnew.bi.com/bidotcomnew/?portfolio_category=gps-tracking-portfolio">GPS Monitoring Portfolio</a> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="813" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="HomeGuard" title="HomeGuard" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_hg-2x03fw3lo4nsfr20rtga2o.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/homeguard/"><i class="mk-icon-link"></i></a><a data-title="HomeGuard" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_hg.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/homeguard/">HomeGuard</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="814" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="VoiceID" title="VoiceID" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_voiceid-2x03f6uejbixu00scpahhc.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/voice-verification/voiceid/"><i class="mk-icon-link"></i></a><a data-title="VoiceID" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/05/port_voiceid.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/voice-verification/voiceid/">VoiceID</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2131" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image alcohol-monitoring-portfolio"><div class="portfolio-classic-holder"><div class="featured-image"><img alt="TAD" title="TAD" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_tad-2x03g49md5b12wkot4gwe8.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/alcohol-monitoring/tad/"><i class="mk-icon-link"></i></a><a data-title="TAD" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_tad.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/alcohol-monitoring/tad/">TAD</a></h3><div class="clearboth"></div><div class="portfolio-categories"><a href="http://bidotcomnew.bi.com/bidotcomnew/?portfolio_category=alcohol-monitoring-portfolio">Alcohol Monitoring Portfolio</a> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2218" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="Sobrietor" title="Sobrietor" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_sobrietor-2x03fia13y12qey4ej45j4.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/alcohol-monitoring/sobrietor/"><i class="mk-icon-link"></i></a><a data-title="Sobrietor" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_sobrietor.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/alcohol-monitoring/sobrietor/">Sobrietor</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2219" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="GroupGuard" title="GroupGuard" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_gg-2x03fg9nn9i29n068o5nuo.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/groupguard/"><i class="mk-icon-link"></i></a><a data-title="GroupGuard" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_gg.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/products/electronic-monitoring/groupguard/">GroupGuard</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2214" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="EM Offices" title="EM Offices" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_emoffices-2x03fb8pzk6j3p5au0rfnk.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/em-offices/"><i class="mk-icon-link"></i></a><a data-title="EM Offices" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_emoffices.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/em-offices/">EM Offices</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2220" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="GuardServer" title="GuardServer" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_gs-2x03fd01rnn60dli85cm4g.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/monitoring-host/guardserver/"><i class="mk-icon-link"></i></a><a data-title="GuardServer" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_gs.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/monitoring-host/guardserver/">GuardServer</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2221" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="TotalAccess" title="TotalAccess" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_ta-2x03hei80tgbsr9ijwi70g.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/totalaccess-software/"><i class="mk-icon-link"></i></a><a data-title="TotalAccess" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_ta.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/totalaccess-software/">TotalAccess</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>


<article id="2222" class="mk-portfolio-item mk-portfolio-classic-item mk-isotop-item portfolio-three-column portfolio-full-layout portfolio-image "><div class="portfolio-classic-holder"><div class="featured-image"><img alt="Monitoring Operations" title="Monitoring Operations" src="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/bfi_thumb/port_monitoring_ops-2x03f8zaual52tplwffmrk.jpg"  /><div class="image-hover-overlay"></div><a class="permalink-badge" target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/monitoring/bi_monitoring_ops/"><i class="mk-icon-link"></i></a><a data-title="Monitoring Operations" class="zoom-badge portfolio-classic-lightbox mk-lightbox" href="http://bidotcomnew.bi.com/bidotcomnew/wp-content/uploads/2014/06/port_monitoring_ops.jpg"><i class="mk-icon-zoom-in"></i></a></div><div class="portfolio-meta-wrapper"><h3 class="the-title"><a target="_self" href="http://bidotcomnew.bi.com/bidotcomnew/services-2/monitoring/bi_monitoring_ops/">Monitoring Operations</a></h3><div class="clearboth"></div><div class="portfolio-categories"> </div><div class="the-excerpt"></div></div><div class="clearboth"></div></div></article>

</div>
</body>