@extends('layouts.dashlayout')


@section('title')
    <title>Doctor Form</title>
@endsection


@section('header')
    <h5><b>Fill up necessary information</b></h5>
    <center>
    @if(session()->has('fail'))
        <div class="w3-panel w3-red">
            <h4> {{session()->get('fail')}}</h4>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="w3-panel w3-green">
            <h4> {{session()->get('success')}}</h4>
        </div>
    @endif
    </center>
@endsection


@section('content')
<center>
    <div class="w3-panel">
    <form method="post" action="docinfo" enctype="multipart/form-data">
        @csrf

            <div class="w3-row-padding w3-margin" style="width: 70%">

                <h5><b>Doctor's Information</b></h5>
                <table class="w3-table w3-white">
                    <tr>
                        <td>
                            <select name="department" type="text"
                                    class="w3-input form-control @error('department') is-invalid @enderror"  required>
                                <option>Select Department...</option>

                                @foreach($department as $dpt)
                                    <option value={{$dpt->dptcode}}> {{$dpt->dptname}} </option>
                                @endforeach

                            </select>

                            @error('department')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror

                        </td>
                    </tr>
                    <tr>
                        <td>

                            <b style="margin-left: 12px">Select Visiting Days : </b><br><br>
                            <input type="hidden" name="sat" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="sat" value=1 class="w3-check"> Saturday <br>
                            <input type="hidden" name="sun" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="sun" value=1 class="w3-check"> Sunday <br>
                            <input type="hidden" name="mon" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="mon" value=1 class="w3-check"> Monday <br>
                            <input type="hidden" name="tues" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="tues" value=1 class="w3-check"> Tuesday <br>
                            <input type="hidden" name="wed" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="wed" value=1 class="w3-check"> Wednesday <br>
                            <input type="hidden" name="thurs" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="thurs" value=1 class="w3-check"> Thursday <br>
                            <input type="hidden" name="fri" value=0>
                            <input style="margin-left: 150px" type="checkbox" name="fri" value=1 class="w3-check"> Friday <br><br>

                            @error('days')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <b style="margin-left: 12px">Select Visiting Hours : </b><br>
                         <br>

                            <div class="w3-third">

                           <select class="w3-input" type="text" name="stime" required>
                               <option>Starting Time...</option>
                               <option value="9.0">9 am</option>
                               <option value="10.0">10 am</option>
                               <option value="11.0">11 am</option>
                               <option value="12.0">12 pm</option>
                               <option value="13.0">1 pm</option>
                               <option value="14.0">2 pm</option>
                               <option value="15.0">3 pm</option>
                               <option value="16.0">4 pm</option>
                               <option value="17.0">5 pm</option>
                               <option value="18.0">6 pm</option>
                               <option value="19.0">7 pm</option>
                               <option value="20.0">8 pm</option>
                               <option value="21.0">9 pm</option>
                               <option value="22.0">10 pm</option>
                               <option value="23.0">11 pm</option>


                           </select>

                            </div>

                            <div class="w3-third">
                                <center>
                                   To
                                </center>
                            </div>

                            <div class="w3-third">

                                <select class="w3-input" type="text" name="ftime" required>
                                    <option>Finishing Time...</option>
                                    <option value="10.0">10 am</option>
                                    <option value="11.0">11 am</option>
                                    <option value="12.0">12 pm</option>
                                    <option value="13.0">1 pm</option>
                                    <option value="14.0">2 pm</option>
                                    <option value="15.0">3 pm</option>
                                    <option value="16.0">4 pm</option>
                                    <option value="17.0">5 pm</option>
                                    <option value="18.0">6 pm</option>
                                    <option value="19.0">7 pm</option>
                                    <option value="20.0">8 pm</option>
                                    <option value="21.0">9 pm</option>
                                    <option value="22.0">10 pm</option>
                                    <option value="23.0">11 pm</option>
                                    <option value="24.0"> 12 am</option>

                                </select>


                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <br>
                            <b style="margin-left: 12px">Select Visiting Charge : </b>
                            <select class="w3-input" type="text" name="rate" required>
                                <option></option>
                                @for($i=100;$i<=1000;$i+=100)
                                    <option value="{{$i}}">৳ {{$i}}</option>
                                 @endfor
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><br>
                            <b style="margin-left: 12px">Attach CV and Other Documents (Make one PDF File) : </b><br><br>
                            <input  type="file" name="cv" accept="application/pdf" style="margin-left: 150px" id="filetype" onchange="validateFileType()" required>
                        </td>
                    </tr>

                    <tr>
                        <td class="w3-right"><button class="w3-button w3-black w3-hover-teal">Submit</button></td>
                    </tr>

                </table>


            </div>


    </form>
    </div>

{{--    <div class="w3-pane w3-half">--}}
{{--        <div class="w3-row-padding w3-margin">--}}

{{--            <h5><b>Terms and Conditions</b></h5>--}}
{{--        </div>--}}


{{--    </div>--}}




    <script type="text/javascript">
        function validateFileType(){
            var fileName = document.getElementById("filetype").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="pdf"){
                //TO DO
            }else{
                alert("Only PDF files are allowed!");
                document.getElementById('filetype').value=null;

            }
        }
    </script>

</center>
@endsection
