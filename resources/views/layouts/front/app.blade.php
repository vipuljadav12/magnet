<!doctype html>
<html>
<head>
    @include("layouts.front.common.head")
    @yield('title')
    @yield('styles')
    <style type="text/css">
        label.error{color: red;}
        .d-none{display:none !important; }
        .close {display: none;}
        .d-custom-hide{display: none !important;}
        .b-600.w-110{width: 50% !important}
    #wrapperloading {
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0%;
      left: 0%;
      z-index: 2000;
      display: none;
      background: url({{url('/resources/assets/admin/images/loaderbg.png')}}) repeat;
    }
    #wrapperloading #loading {
      position: fixed;
      top: 40%;
      left: 50%;
      font-weight: bold;
      text-align: center;
    }


    </style>
    <script type="text/javascript" src="{{url('/resources/assets/admin/js/jquery/jquery-3.4.1.min.js')}}"></script> 
    <style type="text/css">.hidden {display:none;}</style>
 </head>
<body>
  @if(!Session::has("from_admin"))
    @include("layouts.front.common.header")
    @endif
<main>
    <div class="container">
      @if(!Session::has("from_admin"))
            {!! getTopLinks() !!}
      @endif
        @yield("language_change")
        @yield("content")
    
    </div>
</main>
<footer>
    
<!-- Modal HTML -->
<div class="modal fade" id="infopopup">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Marketplace Order Fulfillment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <div class="modal-content">
                </div>
          
                
            </div>
    
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div class="modal fade" id="magntschool" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Existing Magnet Student</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <div class="modal-content p-20">
                  <p>The system has identified this student as a current magnet program student.  Students currently enrolled in a magnet program should NOT complete a magnet program application to indicate intention to continue in the program.  You should only continue with the application if you wish to apply for a different magnet program for your student.</p>
                  <div class="form-group d-flex flex-wrap justify-content-between">
                        <label class="control-label col-12 col-md-4 col-xl-3 pl-0">
                            <a href="{{url('/')}}" class="btn btn-secondary" title="Exit Application"><i class="fa fa-backward"></i>  Exit Application</a>
                         </label>
                         <a href="javascript:void(0)" onclick="return submitToNextPage()" class="btn btn-secondary step-2-2-btn" title="Continue">Continue  <i class="fa fa-forward pl-5"></i></a>
                </div>
                </div>
          
                
            </div>
    
        </div>
    </div>
</div>


</footer>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> 
<script type="text/javascript" src="{{url('/resources/assets/admin/js/bootstrap/bootstrap.min.js')}}"></script> 
<script type="text/javascript" src="{{url('/resources/assets/admin/js/switchery.min.js')}}"></script> 
<script type="text/javascript" src="{{url('/resources/assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('/resources/assets/admin/plugins/bootstrap-datepicker/js/bs-date-picker-init.js')}}"></script>
<script src="{{asset('resources/assets/admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('resources/assets/admin/js/additional-methods.min.js')}}"></script>
<script src="{{url('/resources/assets/front/js/jquery/jquery_input_mask.js')}}"></script>
<script src="{{url('/resources/assets/admin/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>



    <div id="wrapperloading" style="display:none;"><div id="loading"><i class='fa fa-spinner fa-spin fa-4x'></i> <br> <span id="loadmsg">API Successfully Started<br>It will take approx 1 minute to bring all student records.</span> </div></div>    

@yield("scripts")
<script type="text/javascript">
        var magnetStudent = false;
        
        $('.ls-modal').on('click', function(e){
          e.preventDefault();
          $('#infopopup').modal('show').find('.modal-title').html($(this).attr('title'));
          $('#infopopup').modal('show').find('.modal-body').load($(this).attr('href'));
        });

        function removeValidateSubmit()
        {
          
          $('input, select, textarea').each(function() {
              $(this).rules('remove', 'required');
          });
            jQuery('form#programform').validate({
               onsubmit : false
            });
            $("input").removeAttr("required"); 
            //$("#programform").unbind('submit');
        }

        function checkDOB(event)
        {
          if($("#student_id").length > 0)
          {
             var url = "{{url('/check/student/')}}/"+$("#student_id").val()+"/"+$("#current_grade").val();
              $.ajax({
                url:url,
                method:'get',
                success:function(response){
                    if($.trim(response) == "Magnet")
                    {
                      magnetStudent = true;
                    }
                    else
                    {
                      magnetStudent = false;
                    }
                }
              });
          }
          if($("#birthdayFiller").length > 0)
          {
              if(!birthdateCheck())
               {
                //alert('Birth Date should not be earlier than '+$("#bdate_validation").val());
                swal({
                    text: "{{getAlertMsg('birthdate_validate')}}",
                    type: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#d62516"
                });
                return false;
               }
          }

          if($("#student_id").length > 0)
          {
            if(magnetStudent == true)
            {
               event.preventDefault();
               $("#magntschool").modal('show');
               return false;
            }
          }

          return true;
        }

        function changeNextGrade(obj)
        {
            $('#next_grade').children('option').remove();
            if($.isNumeric($(obj).val()))
            {
               $("#next_grade").append('<option value="'+(parseInt($(obj).val())+1)+'">'+(parseInt($(obj).val())+1)+'</option>');
               //addNormalGrade(parseInt($(obj).val())+1);
            }
            else if($(obj).val()=="None")
            {
                $("#next_grade").append('<option value="PreK">PreK</option>');
                //addNormalGrade(1);
            }            
            else if($(obj).val()=="PreK")
            {
                $("#next_grade").append('<option value="K">K</option>');
                //addNormalGrade(1);
            }
            else if($(obj).val()=="K")
            {
               $("#next_grade").append('<option value="1">1</option>');
               //addNormalGrade(1); 
            }
            else
            {
               $("#next_grade").append('<option value=""></option>');
               // $("#next_grade").append('<option value="PreK">PreK</option>');
               // $("#next_grade").append('<option value="K">K</option>');
               // addNormalGrade(1);   
            }
            changeDOBValidate();
        }

        function addNormalGrade(val)
        {
            for(i=val; i <= 12; i++)
            {
                $("#next_grade").append('<option value="'+i+'">'+i+'</option>');
            }
        }

        $("#first_choice").change(function(){
          var val = $(this).val();
          
          $('#second_choice > option').each(function(){
              if($(this).val() == val && val != "")
                $(this).addClass("d-none");
              else
                $(this).removeClass("d-none");
          });


        var url = "{{url('/check/program/sibling/')}}/"+val;
          $.ajax({
            url:url,
            method:'get',
            success:function(response){
                if($.trim(response) == "Y")
                {
                  $("#first_sibling_part_1").removeClass("d-none");
                }
                else
                {
                  $("#first_sibling_part_1").addClass("d-none");
                }
            }
          });


        })

        $("#second_choice").change(function(){
          var val = $(this).val();
          $('#first_choice > option').each(function(){
              if($(this).val() == val && val != "")
                $(this).addClass("d-none");
              else
                $(this).removeClass("d-none");
          });
              var url = "{{url('/check/program/sibling/')}}/"+val;
              $.ajax({
                url:url,
                method:'get',
                success:function(response){
                    if($.trim(response) == "Y")
                    {
                      $("#second_sibling_part_1").removeClass("d-none");
                    }
                    else
                    {
                      $("#second_sibling_part_1").addClass("d-none");
                    }
                }
              });


          
        })

        $(document).ready(function() 
        {
          changeNextGrade($("#current_grade"));
           $( function() {
            $(".help").tooltip();
          });
            if($("#phone_number").length > 0)
            {
                $('#phone_number').inputmask("(999) 999-9999");
            }
            if($("#alternate_number").length > 0)
            {
                $('#alternate_number').inputmask("(999) 999-9999");
            }

            const monthNames = ["January", "February", "March", "April", "May", "June",
              "July", "August", "September", "October", "November", "December"
            ];
              var currentYear = new Date().getFullYear();
              var limitYear = $(document).find("#limitYear").val();
              var limitMonth = $(document).find("#limitMonth").val();
              var limitDay = $(document).find("#limitDay").val();

              var qntYears = currentYear - limitYear + 1;
              console.log(currentYear+" -- "+limitYear+"--"+qntYears);
              // var qntYears = 30;
              var selectYear = $("#year");
              var selectMonth = $("#month");
              var selectDay = $("#day");
              
              var currentYear = {{date("Y")}};
              for (var y = 0; y < 20; y++){
                let date = new Date(currentYear);
                var yearElem = document.createElement("option");
                yearElem.value = currentYear 
                yearElem.textContent = currentYear;
                selectYear.append(yearElem);
                currentYear--;
              } 

              for (var m = 0; m < 12; m++){
                  let monthNum = new Date(2018, m).getMonth()
                  let month = monthNames[monthNum];
                  var monthElem = document.createElement("option");
                  if(monthNum+1 > 9)
                      monthElem.value = monthNum+1;
                  else
                      monthElem.value = "0"+(monthNum+1); 
                  monthElem.textContent = month;
                  selectMonth.append(monthElem);
                }

                
                var d = new Date();
                  var month = d.getMonth();
                  var year = d.getFullYear();
                  var day = d.getDate();
                  selectYear.val(limitYear); 
                  selectMonth.val(limitMonth);
                  
                
                
                //selectYear.on("change", AdjustDays);  
                //selectMonth.on("change", AdjustDays);
                AdjustDays();
                
                
                function AdjustDays(){
                  var year = selectYear.val();
                  console.log("year::" + year);
                  var month = parseInt(selectMonth.val()) + 1;
                  selectDay.empty();
                  
                  //get the last day, so the number of days in that month
                  var days = new Date(year, month, 0).getDate(); 
                  
                  //lets create the days of that month
                  for (var d = 1; d <= 31; d++){
                    var dayElem = document.createElement("option");
                    if(d < 10)
                        dayElem.value = "0"+d;
                    else 
                      dayElem.value = d;
                        dayElem.textContent = d;
                    selectDay.append(dayElem);
                  }
                  selectDay.val(limitDay);
                }

                if($("#birthdayFiller").length > 0)
                {
                  if($("#birthdayFiller").val() != "")
                  {

                      var tmpDate = $("#birthdayFiller").val().split("-");
                      if(typeof tmpDate[0] !=='undefined')
                      {
                        //selectYear.val(tmpDate[0]);
                      }
                      if(typeof tmpDate[1] !=='undefined')
                      {
                        //selectMonth.val(tmpDate[1]);
                      }
                      if(typeof tmpDate[2] !=='undefined')
                      {
                        //selectDay.val(tmpDate[2]);
                      }
                  }    
                }

                if($("#mcp_employee_enable").length > 0)
                {
                  if($("#mcp_employee_enable").val() == "1")
                  {
                      if($("#employee_id").length > 0)
                      {
                        $("#employee_id").show();
                      }
                      if($("#work_location").length > 0)
                      {
                        $("#work_location").show();
                      
                      }
                      if($("#employee_first_name").length > 0)
                      {
                        $("#employee_first_name").show();
                      
                      }
                      if($("#employee_last_name").length > 0)
                      {
                        $("#employee_last_name").show();
                      
                      }

                  }
                }

                if($("#next_grade").length > 0)
                {
                  changeDOBValidate();    
                }
            });
    
    $("#year").change(function(){
       /*if(!birthdateCheck())
       {
        alert('Birth Date should not be earlier than '+$("#bdate_validation").val());
        var rsp = $("#bdate_validation").val();
        var year = rsp.split("-");
        //$("#month").val(year[1]);
        $("#year").val(year[0]);

        $("#year").focus();
       }*/
    })

    $("#month").change(function(){
       /*if(!birthdateCheck())
       {
        alert('Birth Date should not be earlier than '+$("#bdate_validation").val());
        var rsp = $("#bdate_validation").val();
        var year = rsp.split("-");
        $("#month").val(year[1]);
        //$("#day").val(year[2]);
        $("#month").focus();
       }*/
    })

    $("#day").change(function(){
     /*  if(!birthdateCheck())
       {
        alert('Birth Date should not be earlier than '+$("#bdate_validation").val());
        var rsp = $("#bdate_validation").val();
        var year = rsp.split("-");
        $("#month").val(year[1]);
        $("#day").val(year[2]);
        $("#day").focus();
       }*/
    })
    function birthdateCheck()
    {
       if($.trim($("#bdate_validation").val()) != "")
        {
          if($("#form_type").val() == "exist")
          {
            return true;
          }
            $tmp =  $("#bdate_validation").val();
            var tmp = $tmp.split("-");

          
            var date1 = new Date(tmp[1]+"/"+tmp[2]+"/"+tmp[0]);
            var date2 = new Date($("#month").val()+"/"+$("#day").val()+"/"+$("#year").val());

            if(date1 < date2){
              return false;
              
            }
            else
              return true;

        }
        else
        {
          return true;
        }
    }

    $("#next_grade").change(function()
      {
           changeDOBValidate();
            
      }
    );

    function changeDOBValidate()
    {
       var url = "{{url('/')}}/getdob/"+$("#next_grade").val()+"/"+$("#application_id").val();
            $.ajax({
                url:url,
                method:'get',
                success:function(response){
                  $("#bdate_validation").val($.trim(response));
                 // var year = response.split("-");
                  //alert(year);
                  /*var currentYear = year[0];
                  
                  $("#month").val(year[1]);
                  $("#day").val(year[2]);

                  $('#year').find('option').remove();
                  var selectYear = $("#year");
                  for (var y = 0; y < 20; y++){
                    let date = new Date(currentYear);
                    var yearElem = document.createElement("option");
                    yearElem.value = $.trim(currentYear) 
                    yearElem.textContent = $.trim(currentYear);
                    selectYear.append(yearElem);
                    console.log(currentYear);
                    currentYear--;
                  } */
//                  $("#birthdayFiller").val($("#year").val()+"-"+$("#month").val()+"-"+$("#day").val());
                }
              });
    }


    $(document).on("change",".changeDate",function()
    {
        let year = $(document).find("#year").val();
        let month = $(document).find("#month").val();
        let day = $(document).find("#day").val();
        $(document).find("#birthdayFiller").val(year+"-"+month+"-"+day);
    });

    function showHideEmployee(obj)
    {
      if($("#employee_id").length > 0 && $("#work_location").length > 0)
      {
        if($(obj).val()=="Yes")
        {
          if($("#mcp_employee_element").length > 0)
          {
            $("#mcp_employee_element").val("Yes");
          }
          $("#employee_id").show();
          $("#work_location").show();

          $("#employee_first_name").show();
          $("#employee_last_name").show();

          $("#employee_id").find("input").attr("required","required");
          $("#work_location").find("input").attr("required","required");
          $("#employee_first_name").find("input").attr("required","required");
          $("#employee_last_name").find("input").attr("required","required");

        }
        else
        {
          if($("#mcp_employee_element").length > 0)
          {
            $("#mcp_employee_element").val("No");
          }
          $("#employee_id").hide();
          $("#work_location").hide();

          $("#employee_first_name").hide();
          $("#employee_last_name").hide();


          $("#employee_id").find("input").removeAttr("required");
          $("#work_location").find("input").removeAttr("required");
          $("#employee_first_name").find("input").removeAttr("required");
          $("#employee_last_name").find("input").removeAttr("required");
        }
      }
    }

    function checkSibling(obj)
    {
      str = $(obj).attr("id");
      if(str == "first_sibling_field")
        var val = $("#first_choice").val();
      else
        var val = $("#second_choice").val();

      if(val != "")
      {
        if($.trim($(obj).val()) != "")
        {
          $(obj).siblings("span").removeClass("hidden");
          $(obj).addClass("hidden");
            var sibling_id = $(obj).val();
            var labelid = $(obj).attr("name")+"_label";
            $("."+labelid).removeClass("hidden");
            var url = "{{url('/check/sibling/')}}/"+sibling_id+"/"+val;
            $.ajax({
              url:url,
              method:'get',
              success:function(response){
                    

                  if($.trim(response) == "")
                  {
                    if($(obj).attr("id") == "student_id")
                    {
                      swal({
                          text: "{{getAlertMsg('sibling_error')}}",
                          type: "warning",
                          confirmButtonText: "OK",
                          confirmButtonColor: "#d62516"
                      });
                    }
                    else
                    {
                      swal({
                          text: "{{getAlertMsg('sibling_error')}}",
                          type: "warning",
                          confirmButtonText: "OK",
                          confirmButtonColor: "#d62516"
                      });
                      var labelid = $(obj).attr("name")+"_label";
                      $("."+labelid).html("");
                    }
                    $(obj).val("");
                    $(obj).focus();
                    $(obj).removeClass("hidden");
                    $(obj).siblings("span").addClass("hidden");


                  }
                  else
                  {
                    $(obj).siblings("span").addClass("hidden");
                    $(obj).removeClass("hidden");
                    if($(obj).attr("id") != "student_id")
                    {
                      var labelid = $(obj).attr("name")+"_label";
                      $("."+labelid).html(response);
                      $("."+labelid).removeClass("hidden");
                    }
                  }
              }
            });
          }
        }
        else
        {
            swal({
                text: "Please select program first",
                type: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "#d62516"
            });
          $(obj).val("");
        }
    }

    function checkStudentID(obj)
    {
      var val = $.trim($(obj).val());

       if(val != "")
        {
          $(obj).siblings("span").removeClass("hidden");
          $(obj).addClass("hidden");
          
            var url = "{{url('/check/student/')}}/"+val;
            $.ajax({
              url:url,
              method:'get',
              success:function(response){
                  if($.trim(response) == "")
                  {
                    //swal("Invalid Student ID",'',"error");

                     swal({
                          text: "Invalid Student ID",
                          type: "warning",
                          confirmButtonText: "OK",
                          confirmButtonColor: "#d62516"
                      });
                    //alert("");
                    $(obj).val("");
                    $(obj).focus();
                  }
                  else if($.trim(response) == "Higher")
                  {
                    //swal("Invalid Student ID",'',"error");

                     /*swal({
                          text: "{{getAlertMsg('no_program_available')}}",
                          type: "warning",
                          confirmButtonText: "OK",
                          confirmButtonColor: "#d62516"
                      });
                    //alert("");
                    $(obj).val("");
                    $(obj).focus();*/
                    document.location.href = "{{url('/msgs/nograde')}}";
                  }
                  else
                  {
                      if($.trim(response) == "Magnet")
                      {
                          magnetStudent = true;
                      }

                  }  
                  
                  $(obj).removeClass("hidden");
                  $(obj).siblings("span").addClass("hidden");

              }
            });
          }
    }

    function submitForm(event)
    {

      if($("#first_choice").length > 0)
      {
          if($("#first_choice").val() == "")
          {
            swal({
                    text: "Please select at least one program",
                    type: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#d62516"
                });
              return false;
          }
          if($("#customRadioInline1").prop("checked"))
          {
             if(jQuery("#first_sibling_field").val() == "")
             {
                swal({
                      text: "Please enter Sibling State ID",
                      type: "warning",
                      confirmButtonText: "OK",
                      confirmButtonColor: "#d62516"
                  });
                return false;
             }
          }
          

          if($("#customRadioInline3").prop("checked"))
          {
             if(jQuery("#second_sibling_field").val() == "")
             {
                swal({
                      text: "Please enter Sibling State ID",
                      type: "warning",
                      confirmButtonText: "OK",
                      confirmButtonColor: "#d62516"
                  });
                return false;
             }
          }

      }

      event.preventDefault();
      swal({
          title: '',
          text: "Are you sure you would like to submit your application ?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }).then(function(isConfirm) {
          $('form[name="programform"]').removeAttr('onsubmit');
          $("#np").removeAttr('onclick');
//          $("#programform" ).trigger( "submit" );
          $("#np").trigger('click');
        })

      //var txt;
     
    }


    function printDiv()
    {
      var divContents = "<div>"+document.getElementById("logo").innerHTML+"</div>";

      divContents += "<div>"+document.getElementById("printmsg").innerHTML+"</div>";
      var a = window.open('', '', 'height=500, width=500'); 
      a.document.write('<html>'); 
      a.document.write('<body>'); 
      a.document.write(divContents); 
      a.document.write('</body></html>'); 
      a.document.close(); 
      a.print(); 
    }

    function submitToNextPage()
    {
      $("#magntschool").modal('hide');
      $('form[name="programform"]').removeAttr('onsubmit');
      $("#programform" ).trigger( "submit" );
      $("#np").trigger('click');
    }

    function changeLanguage(lang="english")
    {
        var url  = '{{ url("/change/language/")}}/'+lang;
        $.ajax({
            url:url,
            method:'get',
            success:function(response){
                location.reload();
            }
        });
    }
</script>
</body>
</html>