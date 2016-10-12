<?php
// $Id: page.tpl.php,v 1.18 2008/01/24 09:42:53 goba Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>

<script src="<?php print base_path(). path_to_theme(); ?>/scripts/panel.js" type="text/javascript"></script> 
<script src="<?php print base_path(). path_to_theme(); ?>/scripts/mootools.js" type="text/javascript"></script>
<script src="<?php print base_path(). path_to_theme(); ?>/scripts/moocheck.js" type="text/javascript"></script>
<script src="<?php print base_path(). path_to_theme(); ?>/scripts/jquery-1.7.1.min.js" type="text/javascript"></script>   
    
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
  </head>
  <body>

<!-- Layout -->

 <div id="quickBar">
            <div class="quickCtr">
                <div id="qb-show">The Geo Family of Websites</div>
            </div>
        </div>
 
        <div id="quickBarEXP">
            <div class="quickCtr">
                <ul id="quickBarMenu">
                    <li id="q1"><a href="http://www.geogroup.com">Geo Group</a></li>
                    <li id="q2"><a href="http://bi.com">BI Incorporated</a></li>
                    <li id="q3"><a href="http://www.georeentry.com/">Geo Reentry</a></li>
                    <li id="q4"><a href="http://www.abraxasyfs.com/">Abraxas</a></li>
                    <li id="q5"><a href="http://geogroupfoundation.com/">Geo Foundation</a></li>
                    <li id="q6"><a href="http://jobs.geogroup.com/">Geo Careers</a></li>
                    <li id="q7"><a href="http://www.facebook.com/GEOGroup">Geo Facebook</a></li>
                     <li id="q8"><a href="https://twitter.com/suparecruita">Geo Twitter</a></li>
                </ul>
            
                <div id="qb-hide">The Geo Family of Websites</div>
            </div>
        </div>        
    <!-- end Quickbar--></div>
    
<script type="text/javascript" src="<?php print base_path(). path_to_theme(); ?>/scripts/quickbar.js"></script>

  <div id="container"> <!-- BEGIN- container -->
	<div id="wrapper"><!-- BEGIN- wrapper -->

	  <div id="topbar"><!-- BEGIN- topbar -->
		<div id="topnav">
		  <div class="links">
		  <ul>
		  <li><a href="/careers">Careers</a></li>
		  <li class="bordernone"><a href="/contact">Contact Us</a></li>
		  </ul>
		  <div class="container-inline">
			<?php if ($search_box): ?><?php print $search_box ?><?php endif; ?>
		  </div>
		</div>
		</div>

		<?php
        if ($logo || $site_title) {
            print '<div class="logo"><a href="'. check_url($front_page) .'" title="'. $site_title .'">';
            if ($logo) {
              print '<img src="'. check_url($logo) .'" alt="BI Incorporated" border="0" />';
            }
            print $site_html .'</a></div>';
          }
        ?>
</div><!-- END- topbar -->

		<!-- BEGIN- header -->
		<div id="header">
		<img src="<?php print base_path(). path_to_theme(); ?>/images/img_header.jpg" alt="BI Incorporated" />
		</div>
		<!-- END- header -->
		
<!-- BEGIN- nav -->		
<div id="nav">
	<div class="links">
		         <?php if (($secondary_links)) : ?>
          <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
        <?php endif; ?>
	</div>
</div>
<!-- /nav -->
 
<div id="content">
<div id="products"><!-- BEGIN- column 1 -->
<?php print $content ?>
</div><!-- END- column 1 -->

</div>

<?php
    global $user;
	if ($user->uid) : ?>
		<?php print '<div id="AdminBar" align="center">' ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php if ($tabs): print $tabs .'</div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($show_messages && $messages): print $messages; endif; ?>
		<?php print '</div>' ?>

	<?php endif; ?>

	</div><!-- END- wrapper -->
  <!-- footer -->
  <div id="footer">
	<?php print $footer_message . $footer ?>
  </div>
</div>
<!-- /container -->

<!-- /layout -->
  <?php print $closure ?>
</body>
</html>
