<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Controle de parágrafos</title>
  <!--Custon CSS (está em /public/assets/site/css/certificate.css)-->

  <style>
    table {
      font-size: 14px;
    }

    table {
      width: 100%
    }

    thead td {
      padding: 5px;
      font-weight: bold;
    }

    td {
      border: 1px solid #000;
    }

    hr {
      margin-top: 20px;
    }

    tbody tr td:first-child {
      text-align:center;
    }

    .no-border {
      border: none;
    }

    .centered td, .centered{
      text-align:center;
    }


    h1 {
      color: #8e8e8e;
    }

    img {
      height: 75px;
      float:left;
    }

    div#observations {
        width: 90%;
        margin: 0 auto;
        margin-top: 10px;
    }

    ul {
        margin: 0;
        padding:0;
        text-decoration: none;
        list-style-type: none;
    }

    .white {
        color: #FFFFFF;
    }

    .font-12 {
        font-size: 10pt;
        padding: 0;
    }

  </style>
</head>
<body>
  <div>
    <img src="{{public_path('images/logoatt.svg')}}" alt="CRM">
    <h1 style='text-align:right'>PARAGRAPHS CONTROL</h1>
  </div>
  <table cellspacing="0">
    <thead>
      <tr>
        <td class='no-border'>&nbsp;</td>
        <td colspan="3">
            GROUP NAME: <br/>{{ $groupClass->name}}
            <br/>
        </td>
        <td>TIME:
            <br/>{{$groupClass->time_schedule}}
            <br/>
        </td>
        <td>{{$book->name}}
            <br/>
            <br/>
        </td>
        <td>STARTED:
            <br/>
            <br/>
        </td>
      </tr>
      <tr>
        <td class='no-border'>&nbsp;</td>
        <td colspan="6">STUDENTS:
            @foreach ($groupClass->students as $student)
                {{$student->nickname ?? $student->name}} @if (!$loop->last), @endif
            @endforeach
        </td>
      </tr>
      {{-- <tr>
        <td class='no-border'>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
      </tr> --}}
      <tr class='centered'>
        <td class='no-border font-12'>&nbsp;</td>
        <td class="font-12">DATE</td>
        <td class="font-12">PAGE</td>
        <td class="font-12">STOP</td>
        <td class="font-12">ACTIVITY</td>
        <td class="font-12" style="width: 30%">OBSERVATION</td>
        <td class="font-12">TEACHER</td>
      </tr>
    </thead>
    <tbody>
      @for ($i = 1; $i <= $qty; $i++)
        <tr class="row">
          <td scope="row">{{$i}}</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      @endfor

    </tbody>
  </table>

    <div id="observations">
        <strong>General observations</strong>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>

        <strong>Activities</strong>

        <div style="clear:both; position:relative; margin-top:5px;">
            <div style="position:absolute; left:0pt; width:192pt;">
                <ul>
                @foreach ($book->activities as $activity)

                    @if ($loop->index < 5)
                        <li>{{$loop->index+1}}. {{$activity->name}}</li>
                    @endif

                @endforeach
                </ul>
            </div>
            <div style="margin-left:200pt;">
                <ul>
                @foreach ($book->activities as $activity)
                    @if ($loop->index >= 5)
                        <li>{{$loop->index+1}}. {{$activity->name}}</li>
                    @endif
                @endforeach
                </ul>
            </div>
        </div>
    </div>



</body>
</html>
