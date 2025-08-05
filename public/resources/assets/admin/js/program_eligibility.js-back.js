$(document).ready(function()
	{
		$('.determination_method').on('change input', function () {
                changeIcon($(this), 0);
            });
		$('.assigned_eigibility_name').on('change input', function () {
                changeIcon($(this), 0);
            });
		$('.weight').on('change input', function () {
                changeIcon($(this), 0);
            });
		$('.eligibility_status').on('change input', function () {
                changeIcon($(this), 0);
            });

		$(".gradeClass").change(function(){

			var elName = $(this).attr('name');
			elName = elName.replace("eligibility_grade_lavel", "");
			elName = elName.replace("[]", "");
			elName = elName.replace("[", "");
			elName = elName.replace("]", "");

			var strGrade = "";
			console.log("initiate strGrade = "+ strGrade);
			$("input[name='"+$(this).attr('name')+"']").each(function() {
				if($(this).prop("checked") == true)
				{
					strGrade += $(this).val()+"-";
					console.log("initiate strGrade = "+ strGrade);

				}
			})
//			alert(strGrade);
			$("#grade"+elName).val(strGrade);

			var currentId = $("#grade"+elName);
		//	var obj = $(currentId).closest('tr');
			changeIcon($("#grade"+elName), 0);
		})
});



function changeIcon(obj, val)
{
	if(val==0)
		var trObj = $(obj).closest('tr');
	else
		var trObj = $(obj);
	 
	var dMthod = $(trObj).find(".determination_method").val();
	var dElName = $(trObj).find(".assigned_eigibility_name").val();
	var dWeight = $(trObj).find(".weight").val();
	var dStatus = $(trObj).find(".eligibility_status").prop('checked');
	var dGrade = $(trObj).find(".gradeval").val();

	 
	
	var status = "Pending";
	if(dMthod == "" && dElName == "" && dStatus == false && dGrade == "")
	{
		$(trObj).find(".statusimg").attr('src',BASE_URL+"/resources/assets/admin/images/close.png");
		$(trObj).find(".tooltiptext").html("Not Applicable");
	}
	
	if(dMthod != "" || dElName != "" || dStatus == true || dWeight != "" || dGrade != "")
	{
		$(trObj).find(".statusimg").attr('src',BASE_URL+"/resources/assets/admin/images/alert.png");
		$(trObj).find(".tooltiptext").html("Awaiting Assignment");	
	}

	if(dMthod != "" && dElName != "" && dStatus == true && dGrade != "")
	{
		if(dMthod == "Combined" && dWeight != "")
			$(trObj).find(".statusimg").attr('src',BASE_URL+"/resources/assets/admin/images/right.png");
		else if(dMthod == "Basic")
			$(trObj).find(".statusimg").attr('src',BASE_URL + "/resources/assets/admin/images/right.png");
		$(trObj).find(".tooltiptext").html("Assignment Completed");
	}

//	 console.log($i);
}

function showGradePopup(eligibility_id, name)
{
	$('#modal_1').modal('show');
	var values = $("#grade"+eligibility_id).val();
	var gradeArr = values.split("-");
	$(".eligibility_type_name").html(name);
	$(".gradeClass").each(function(){
		$(this).attr("name", "eligibility_grade_lavel["+eligibility_id+"][]");

		if($.inArray($(this).val(), gradeArr) >= 0)
			$(this).prop("checked", true);
		else	
			$(this).prop("checked", false);
	})	

}