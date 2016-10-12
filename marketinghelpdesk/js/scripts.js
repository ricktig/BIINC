//Marketing Help Desk JavaScript functions
//May 14, 2015
//Rick Rose

//AJAX call to fetch LI list of tbluser FirstName, pkId
function fetchUserFirstNamebyLi()
{
	$.ajax(
	{
		method:"POST",
		url:"php/fetchusersbyli.php",
		dataType:"html",
		success: function(myusersli)
		{
			$("#allmarketing").append(myusersli);
		}
	});
}//end fetchUserFirstNamebyLi()

//AJAX call to fetch Select of tblcategories CategoryName, pkId
function fetchCategoriesbyOption()
{
	$.ajax(
	{
		method:"POST",
		url:"php/fetchcategoriesbyselect.php",
		dataType:"html",
		success: function(mycategoriesselect)
		{
			$("#category").append(mycategoriesselect);
		}
	});
}//end fetchCategoriesbyOption()

//function to fetch Select of priorities
function fetchPrioritiesbyOption()
{
	var mypriorities = "<option value=''>Select</option><option value='1'>High - 1 Hour</option><option value='2'>Medium - 1 Day</option><option value='3'>Low - 1 Week</option><option value='4'>Ongoing</option>";
	$("#priority").append(mypriorities);
}//end fetchPrioritiesbyOption()

//function to fetch Select of status'
function fetchStatusbyOption()
{
	var mystatus = "<option value=''>Select</option><option value='1'>Open: Unassigned</option><option value='2'>Open: Work Not Started</option><option value='3'>Open: Active</option><option value='4'>Open: Inactive</option><option value='5'>Closed: Complete</option>";
	$("#status").append(mystatus);
}//end fetchStatusbyOption()

function clearForm()
{
	$("#shortdescription").val('');
	$("#longdescription").val('');
	$("#tasktype").val('');
	$("#priority").val('');
	$("#duedate").val('');
	$("#duetime").val('');	

}