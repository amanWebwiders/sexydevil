@extends('admin.layout.layout')

@section('content')

<style>

    input.pe-2 {

        margin-right: 5px;

        position: relative;

        top: 2px;

    }

.fc-time {

    display: none;

}

    #calendar {

      max-width: 900px;

      margin: 40px auto;

      background: #fff;

      padding: 10px;

      box-shadow: 0 0 10px rgba(0,0,0,0.1);

      border-radius: 8px;

    }

#wrap {

  width: 1100px;

  margin: 0 auto;

}



.closeon {

  border-radius: 5px;

}



/*info btn*/

.dropbtn {

    /*background-color: #4CAF50;*/

    background-color: #eee;

    margin: 10px;

    padding: 8px 16px 8px 16px;

    font-size: 16px;

    border: none;

}



.dropdown {

    position: relative;

    display: inline-block;

}



.dropdown-content {

    display: none;

    position: absolute;

    background-color: #f1f1f1;

    min-width: 200px;

    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);

    z-index: 1;

  margin-left: 100px;

  margin-top: -200px;

}



.dropdown-content p {

    color: black;

    padding: 4px 4px;

    text-decoration: none;

    display: block;

}



.dropdown-content a:hover {background-color: #ddd;}



.dropdown:hover .dropdown-content {display: block;}



.dropdown:hover .dropbtn {background-color: grey;}



.dropdown:hover .dropbtn span {color: white}



</style>



<div id="content" class="app-content">



    <div class="d-lg-flex align-items-end mb-4">

        <h3 class="page-header mb-lg-0">Boost/Featured Users</h3>

    </div>



    <div class="card p-4">



        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"

                tabindex="0">

                <form id="fetchFeatureDevils" >

                <div class="row">

                    <div class="col-sm-2">

                        <label>Country</label>

                        <select id="country" onchange="return fetchState($(this))" name="country" class="form-control" >

                            @foreach ($my_country as $_country)

                                <option value="{{ $_country['id'] }}">{{ $_country['country'] }} ({{ $_country['total_users'] }})</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-sm-3">

                        <label>State</label>

                        <select id="state" onchange="return fetchCity($(this))" name="state" class="form-control" >

                            <option value="">-- select ---</option>

                            @foreach ($state as $_state)

                                <option value="{{ $_state->id }}">{{ $_state->name }} ({{ $_state->users_count }})</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-sm-3">

                        <label>City</label>

                        <select id="city" name="city" class="form-control" >

                            <option value="">-- select ---</option>

                            @foreach ($db_city as $_city)

                                <option value="{{ $_city->id }}">{{ $_city->name }} ({{ $_city->total_users }})</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-sm-3">

                        <label>Advertiser</label>

                        <select id="advertiser" multiple name="advertiser " class="form-control" >

                            @foreach ($users as $_users)

                                <option value="{{ $_users->id }}">{{ $_users->name. " (".$_users->email.")" }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-sm-2">

                        <button type="button" class="btn btn-secondary mt-3" onclick="makeCalender()">Fetch</button>

                    </div>

                </div>

                </form>

                <div id="calendar"></div>

            </div>



        </div>





    </div>







    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="addModalLabel">Add Feature Devil</h5>

                        <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form id="addEventForm" method="POST" onsubmit="return addFeatureDevils()" enctype="multipart/form-data" action="">

                            @csrf

                            <div class="mb-3">

                                <label>Date</label>

                                <input type="text" id="eventDate" class="form-control" name="date" readonly />

                            </div>



                            <div class="mb-3">

                                <label for="heading" class="form-label">Country</label>

                                <input type="text" class="form-control" name="country" readonly>

                            </div>

                            <div class="mb-3">

                                <label>State</label>

                                <input type="text" class="form-control" name="state" readonly> 

                            </div>

                            <div class="mb-3"> 

                                <label>City</label>

                                <input type="text" class="form-control" name="city" readonly>

                                <input type="hidden" class="form-control" name="city_id" />

                            </div> 

                            <div class="mb-3">

                                <label>Select Users</label> 

                                <select name="users[]" multiple id="multiple_users" required class="form-control">



                                </select>

                            </div>



                            <div class="modal-footer p-0">

                                <button type="submit" id="udpate_changes" class="btn btn-primary">Save</button>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            </div>

                        </form>

                    </div>



                </div>

            </div>



        </div>

    <div class="modal fade" id="ShowUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="addModalLabel">Selected Feature Devils</h5>

                        <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                    </div>

                    <div class="modal-body"> 

                        <div id="selectedUsers"></div>

                        <div class="modal-footer p-0">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>

                    </div>



                </div>

            </div>



        </div>

    @endsection

    @push('js')

    <script> 

    function fetchState(thiss) {

        var country_id = thiss.val();

        var route = "{{ route('getstates', ['country_id' => ':country_id']) }}"; 

        route = route.replace(':country_id', country_id)+ '?with_users=1';

        $.ajax({

            url: route,

            type:"get",

            dataType:'json',

            beforeSend:function(){ 

                $("#state, #city").html("");

                $("#state").html(`<option value=''>---select state---</option>`);

            },

            success:function(data) {

                $.each(data, function(index, item) {

                    $("#state").append(`<option value='${item.id}'>${item.name} (${item.users_count})</option>`);

                });

                fetchModelsForDropDown();

            }

        });

        return false;

    }



    function fetchCity(thiss) {

        var state_id = thiss.val();

        var route = "{{ route('getcities', ['state_id' => ':state_id']) }}"; 

        route = route.replace(':state_id', state_id)+ '?with_users=1';

        $.ajax({

            url: route,

            type:"get",

            dataType:'json',

            beforeSend:function(){ 

                $("#city").html("");

            },

            success:function(data) {

                $("#city").html(`<option value=''>---select city---</option>`);

                $.each(data, function(index, item) {

                    $("#city").append(`<option value='${item.id}'>${item.name} (${item.users_count})</option>`);

                });

                fetchModelsForDropDown();

            }

        });

        return false;

    }

    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>              



    $.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': "{{ csrf_token() }}"

    }

});



function addEvent(start, end) {

    let formatted = moment(start).format('DD-MM-YYYY');

    $("#eventDate").val(formatted);

    $("#addModal").modal('toggle');



    var form = $("#addEventForm");

    form.find('input[name="country"]').val($.trim($("#country option:selected").text()));

    form.find('input[name="state"]').val($.trim($("#state option:selected").text()));

    form.find('input[name="city"]').val($.trim($("#city option:selected").text()));

    form.find('input[name="city_id"]').val($.trim($("#city option:selected").val()));



    var fetchModelsUrl = "{{ route('admin.fetchModels') }}";



    $.ajax({

        url: fetchModelsUrl,

        type: "POST",

        data: {

            start: moment(start).format('YYYY-MM-DD HH:mm:ss'),

            country: $("#country").val(),

            state: $("#state").val(),

            city: $("#city").val()

        },

        dataType: 'json',

        beforeSend : function() {

            $('#multiple_users').html("");

        },  

        success: function(data) { 

            if(data.record.length > 0) {

                $("#udpate_changes").prop('disabled', false);



                $.each(data.record, function(index, item) {

                        $("#multiple_users").append(`<option value='${item.id}'>${item.name} (${item.email}) </option>`);

                    }); 

                $('#multiple_users').select2();

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: 'No Advertiser found'

                });

                $("#udpate_changes").prop('disabled', true);

            }

        },

        error: function(xhr, status, error) {

            console.error("AJAX Error:", status, error);

            console.log(xhr.responseText);

        }

    });

}



function addFeatureDevils() {

    $.ajax({

        url: "{{ route('admin.addFeatureDevil') }}",

        type: "POST",

        cache:false,

        contentType: false,

        processData: false,

        data: new FormData($('#addEventForm')[0]),

        dataType: 'json',

        success: function(data) { 

            console.log(data);

            if(data.status == 200) {

                $("#addModal").modal('toggle');

                makeCalender([]);

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: data.message

                });

            }

        },

        error: function(xhr, status, error) {

            console.error("AJAX Error:", status, error);

            console.log(xhr.responseText);

        }

    });

    return false;

}





function makeCalender () {

     $("#calendar").fullCalendar('destroy');

    $("#calendar").fullCalendar({

        header: {

        left: "prev,next today",

        center: "title",

        right: "month"

        },

        defaultView: "month",

        navLinks: true, // can click day/week names to navigate views

        selectable: true,

        selectHelper: false,

        editable: true,

        eventLimit: true,

        events: {

            url: "{{ route('admin.fetchFeatureDevils') }}",

            type: "POST",

            data: { 

                _token: "{{ csrf_token() }}",

                country: $("#country").val(),

                state: $("#state").val(),

                city: $("#city").val(),

                advertiser: $("#advertiser").val(),

            },

            error: function() {

                alert("Could not fetch events");

            }

        },

        select: function(start, end) {

            addEvent(start, end);



        /* var title = prompt("Event Content:");

        var eventData;

        if (title) {

            eventData = {

            title: title,

            start: start,

            end: end

            };

            $("#calendar").fullCalendar("renderEvent", eventData, true); // stick? = true

        } */

            //$("#calendar").fullCalendar("unselect");

        },



        eventRender: function(event, element) {

            

            /* element

                .find(".fc-content")

                .prepend("<span class='closeon material-icons'>x</span>");

                element.find(".closeon").on("click", function() {

                $("#calendar").fullCalendar("removeEvents", event._id);

            }); */

        },



        eventClick: function(calEvent) { 

            console.log(calEvent.end._i);

            console.log(calEvent.start._i);

            showSelectedModels(calEvent.start._i, calEvent.end._i);

            //console.log(end);

        /* var title = prompt("Edit Event Content:", calEvent.title);

        calEvent.title = title;

        $("#calendar").fullCalendar("updateEvent", calEvent); */

        }

    });

return false;

}

makeCalender([]);



function showSelectedModels(start, end) {

    $.ajax({

        url: "{{ route('admin.fetchFeatureDevils') }}",

        type: "POST",

        data: {

            country: $("#country").val(),

            state: $("#state").val(),

            city: $("#city").val(),

            start:start,

            end:end,

            "name":1

        },

        dataType: 'json',

        success: function(data) {

            $("#selectedUsers").html("");

            if(data.length > 0) {

                $.each(data, function(index, item) {

                    $("#selectedUsers").append(`<label class='d-block w-75 badge badge-success p-2'>${item.name} (${item.email})</label>`); 

                }); 

                $("#ShowUsers").modal('toggle');

            }

        },

        error: function(xhr, status, error) {

            console.error("AJAX Error:", status, error);

            console.log(xhr.responseText);

        }

    });

}



$(document).ready(function () {

    $('#country, #state, #city, #advertiser').select2();

})

$(document).on("change", "#city", function() {

    fetchModelsForDropDown();

})

function fetchModelsForDropDown() {

    var fetchModelsUrl = "{{ route('admin.fetchModels') }}";

    $.ajax({

        url: fetchModelsUrl,

        type: "POST",

        data: {            

            country: $("#country").val(),

            state: $("#state").val(),

            city: $("#city").val()

        },

        dataType: 'json',

        beforeSend : function() {

            $('#advertiser').html("");

        },  

        success: function(data) { 

            if(data.record.length > 0) {



                $.each(data.record, function(index, item) {

                        $("#advertiser").append(`<option value='${item.id}'>${item.name} (${item.email}) </option>`);

                    }); 

                $('#advertiser').select2();

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: 'No Advertiser found'

                });

            }

        },

        error: function(xhr, status, error) {

            console.error("AJAX Error:", status, error);

            console.log(xhr.responseText);

        }

    });

}

</script>



@endpush('js')